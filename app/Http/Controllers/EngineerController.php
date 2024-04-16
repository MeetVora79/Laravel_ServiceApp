<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EngineerController extends Controller
{
	public function dashboard(Request $request)
	{
		$userId = Auth::user()->id;
		$TicketStaffId = Staff::where('user_id', $userId)->value('StaffId');
		$totalTickets = Allocation::where('AssignId', $TicketStaffId)->count();
		$openTickets = Allocation::join('tickets', 'allocations.TicketId', '=', 'tickets.TicketId')
			->where('allocations.AssignId', $TicketStaffId)
			->where('tickets.TicketStatusId', 1)
			->count();
		$closedTickets =  Allocation::join('tickets', 'allocations.TicketId', '=', 'tickets.TicketId')
			->where('allocations.AssignId', $TicketStaffId)
			->where('tickets.TicketStatusId', 2)
			->count();
		$resolvedTickets =  Allocation::join('tickets', 'allocations.TicketId', '=', 'tickets.TicketId')
			->where('allocations.AssignId', $TicketStaffId)
			->where('tickets.TicketStatusId', 3)
			->count();

		$data = [];
		$priorityData = [];
		$assetData = [];
		$post = DB::table('allocations')
			->join('tickets', 'allocations.TicketId', '=', 'tickets.TicketId')
			->join('statustickets', 'tickets.TicketStatusId', '=', 'statustickets.Statusid')
			->where('allocations.AssignId', $TicketStaffId)
			->select('statustickets.StatusName as label', DB::raw('count(tickets.TicketId) as y'))
			->groupBy('statustickets.StatusName')
			->get()
			->toArray();

		$priority = DB::table('allocations')
			->join('tickets', 'allocations.TicketId', '=', 'tickets.TicketId')
			->join('prioritytickets', 'tickets.TicketPriorityId', '=', 'prioritytickets.Priorityid')
			->where('allocations.AssignId', $TicketStaffId)
			->select('prioritytickets.PriorityName as label', DB::raw('count(tickets.TicketId) as y'))
			->groupBy('prioritytickets.PriorityName')
			->get()
			->toArray();

		$asset = DB::table('schedules')
			->join('assets', 'schedules.AssetId', '=', 'assets.AssetId')
			->where('assets.AssetManagedBy', $TicketStaffId)
			->join('maintenancestates', 'schedules.MaintenanceStatusId', '=', 'maintenancestates.StatusId')
			->select('maintenancestates.StatusName as label', DB::raw('count(DISTINCT schedules.AssetId) as y'))
			->groupBy('maintenancestates.StatusName')
			->get()
			->toArray();

		$startDate = $request->input('startDate', date('Y-m-01'));
		$endDate = $request->input('endDate', date('Y-m-d'));
		$ticketsByDate = DB::table('allocations')
			->where('allocations.AssignId', $TicketStaffId)
			->select(DB::raw('DATE(ServiceDate) as date'), DB::raw('count(*) as count'))
			->whereBetween('ServiceDate', [$startDate . " 00:00:00", $endDate . " 23:59:59"])
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

		return view('engineer.dashboard', compact('data', 'priorityData', 'assetData', 'chartData', 'totalTickets', 'openTickets', 'closedTickets', 'resolvedTickets'));
	}
}
