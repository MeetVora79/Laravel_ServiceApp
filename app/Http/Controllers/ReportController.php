<?php

namespace App\Http\Controllers;

use App\Exports\GenericExport;

use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\Schedule;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Str;

class ReportController extends Controller
{
	public function generateReport(Request $request)
	{
		$reportType = $request->reportType;
		$startDate = Carbon::parse($request->sDate);
		$endDate = Carbon::parse($request->eDate)->endOfDay();
		$exportType = $request->exportType;

		$modelClass = $this->getModelClassFromType($reportType);
		if (!$modelClass) {
			return response()->json(['error' => 'Invalid report type provided.'], 400);
		}

		$data = $this->fetchData($modelClass, $startDate, $endDate);
		$headings = [];
		if ($data->isNotEmpty()) {
			$headings = array_keys($data->first()->getAttributes());
		}

		if ($exportType === 'Excel') {
			return Excel::download(new GenericExport($data, $headings), Str::slug($reportType) . '.xlsx');
			//  } elseif ($exportType === 'CSV') {
			// 	return $this->exportToCsv($modelClass, $startDate, $endDate, Str::slug($reportType) . '.csv');
		} elseif ($exportType === 'PDF') {
			$transformedData = $this->transformDataForTransposedView($data);
			return $this->exportToPdf($transformedData, $reportType);
		}

		return response()->json(['error' => 'Invalid export type provided.'], 400);
	}

	protected function getModelClassFromType($type)
	{
		$map = [
			'Customers' => Customer::class,
			'Tickets' => Ticket::class,
			'Assets' => Asset::class,
			'Maintenance' => Schedule::class,
		];
		return $map[$type] ?? null;
	}

	protected function fetchData($modelClass, $startDate, $endDate)
	{
		$dateColumn = 'created_at';
		if ($modelClass === 'App\Models\Ticket') {
			$dateColumn = 'TicketCreatedAt';
		} elseif ($modelClass === 'App\Models\Asset') {
			$dateColumn = 'AssetCreatedAt';
		}

		$query = $modelClass::whereBetween($dateColumn, [$startDate, $endDate]);
		return  $query->get();
	}


	// protected function exportToCsv($modelClass, $startDate, $endDate, $filename = 'report.csv')
	// {
	// 	$headers = [
	// 		"Content-type" => "text/csv",
	// 		"Content-Disposition" => "attachment; filename={$filename}",
	// 		"Pragma" => "no-cache",
	// 		"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
	// 		"Expires" => "0"
	// 	];

	// 	$callback = function () use ($modelClass, $startDate, $endDate) {
	// 		$file = fopen('php://output', 'w');

	// 		$dateColumn = 'created_at';
	// 		if ($modelClass === 'App\Models\Ticket') {
	// 			$dateColumn = 'TicketCreatedAt';
	// 		} elseif ($modelClass === 'App\Models\Asset') {
	// 			$dateColumn = 'AssetCreatedAt';
	// 		}

	// 		$query = $modelClass::whereBetween($dateColumn, [$startDate, $endDate]);
	// 		$data = $query->get();

	// 		if ($data->count() > 0) {
	// 			fputcsv($file, array_keys($data->first()->getAttributes()));
	// 		}

	// 		foreach ($data as $row) {
	// 			fputcsv($file, $row->getAttributes());
	// 		}

	// 		fclose($file);
	// 	};

	// 	return response()->stream($callback, 200, $headers);
	// }

	public function transformDataForTransposedView($data)
	{
		$transformed = [];

		if ($data->isEmpty()) {
			return $transformed;
		}

		$attributes = array_keys($data->first()->getAttributes());

		foreach ($attributes as $attribute) {
			$row = [$attribute];
			foreach ($data as $item) {
				$row[] = $item->$attribute;
			}
			$transformed[] = $row;
		}

		return $transformed;
	}


	public function exportToPdf($transformed, $reportType)
	{
		// $data = $this->fetchData($modelClass, $startDate, $endDate);
		// $headings = [];

		// if ($data->isNotEmpty()) {
		// 	$headings = array_keys($data->first()->getAttributes());
		// }

		// $pdf = PDF::loadView('reports.pdf', [
		// 	'data' => $data,
		// 	'headings' => $headings,
		// 	'reportTitle' => Str::title($reportType) . ' Report'
		// ])->setPaper('a4', 'landscape');

		$pdf = PDF::loadView('reports.pdf', [
			'transformedData' => $transformed,
			'reportTitle' => Str::title($reportType) . ' Report'
		]);

		return $pdf->download(Str::slug($reportType) . '.pdf');
	}


	public function index(Request $request)
	{

		$totalTickets = Ticket::count('TicketId');
		$openTickets = Ticket::where('TicketStatusId', 1)->count();
		$closedTickets =  Ticket::where('TicketStatusId', 2)->count();
		$resolvedTickets =  Ticket::where('TicketStatusId', 3)->count();
		$assignTickets =  Allocation::count('AllocationId');
		$unassignTickets =  $totalTickets - $assignTickets;
		$totalAsset = Asset::count('AssetId');
		$scheduled = Schedule::count('ScheduleId');
		$unscheduled = $totalAsset - $scheduled;

		$post = DB::table('tickets')
			->join('statustickets', 'tickets.TicketStatusId', '=', 'statustickets.StatusId')
			->select('statustickets.StatusName as label', DB::raw('count(tickets.TicketId) as y'))
			->groupBy('statustickets.StatusName')
			->get()
			->toArray();

		$priority = DB::table('tickets')
			->join('prioritytickets', 'tickets.TicketPriorityId', '=', 'prioritytickets.PriorityId')
			->select('prioritytickets.PriorityName as label', DB::raw('count(tickets.TicketId) as y'))
			->groupBy('prioritytickets.PriorityName')
			->get()
			->toArray();

		$asset = DB::table('schedules')
			->join('maintenancestates', 'schedules.MaintenanceStatusId', '=', 'maintenancestates.StatusId')
			->select('maintenancestates.StatusName as label', DB::raw('count(schedules.ScheduleId) as y'))
			->groupBy('maintenancestates.StatusName')
			->get()->toArray();

		$startDate = $request->input('startDate', date('Y-m-01'));
		$endDate = $request->input('endDate', date('Y-m-d'));
		$ticketsByDate = DB::table('tickets')
			->select(DB::raw('DATE(TicketCreatedAt) as date'), DB::raw('count(*) as count'))
			->whereBetween('TicketCreatedAt', [$startDate . " 00:00:00", $endDate . " 23:59:59"])
			->groupBy('date')
			->orderBy('date', 'ASC')
			->get();

		$chartData = $ticketsByDate->map(function ($item) {
			return ['label' => $item->date, 'y' => $item->count];
		});
		if ($request->ajax()) {
			return response()->json($chartData);
		}

		foreach ($post as $row) {
			$data[] = array(
				'label' => $row->label,
				'y' => $row->y,
			);
		}
		foreach ($priority as $row) {
			$priorityData[] = array(
				'label' => $row->label,
				'y' => $row->y,
			);
		}
		foreach ($asset as $row) {
			$assetData[] = array(
				'label' => $row->label,
				'y' => $row->y,
			);
		}

		return view('reports.index', compact('data', 'priorityData', 'assetData', 'chartData', 'scheduled', 'unscheduled', 'totalTickets', 'openTickets', 'closedTickets', 'resolvedTickets', 'assignTickets', 'unassignTickets'), []);
	}
}
