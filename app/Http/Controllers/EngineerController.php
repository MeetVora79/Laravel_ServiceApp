<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EngineerController extends Controller
{
	public function dashboard(Request $request)
	{
		$userId = Auth::user()->id;
		$TicketStaffId = Staff::where('user_id',$userId)->value('StaffId');
		$totalTickets = Ticket::where('TicketCreaterId', $TicketStaffId)->count();
		$openTickets = Ticket::where('TicketCreaterId', $TicketStaffId)->where('TicketStatusId', 1)->count();
		$closedTickets =  Ticket::where('TicketCreaterId', $TicketStaffId)->where('TicketStatusId', 2)->count();
		$resolvedTickets =  Ticket::where('TicketCreaterId', $TicketStaffId)->where('TicketStatusId', 3)->count();

		$post = DB::table('tickets')
			->join('statustickets', 'tickets.TicketStatusId', '=', 'statustickets.Statusid')
			->select('statustickets.StatusName as label', DB::raw('count(tickets.TicketId) as y'))
			->groupBy('statustickets.StatusName')
			->get()
			->toArray();
		$priority = DB::table('tickets')
			->join('prioritytickets', 'tickets.TicketPriorityId', '=', 'prioritytickets.Priorityid')
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

		return view('engineer.dashboard', compact('data', 'priorityData', 'assetData','chartData', 'totalTickets', 'openTickets', 'closedTickets', 'resolvedTickets'));
	}
}
