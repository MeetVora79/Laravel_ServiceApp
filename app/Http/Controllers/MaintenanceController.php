<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\User;
use App\Models\Staff;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;



class MaintenanceController extends Controller
{

    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'AssetId');
        $direction = $request->get('direction', 'asc');
        $searchTerm = $request->input('searchTerm');
        
        $assetQuery = Asset::query();
        if (!empty($searchTerm)) {
            $assetQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('assets');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $assetQuery->orderBy($sort, $direction);
        $assets = $assetQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('maintenance.index', compact('assets', 'nextDirection'), [
            'users' => User::pluck('name'),
            ]);
    }
  
   
    public function myMaintenance(Request $request): View
    {
        $sort = $request->get('sort', 'ScheduleId');
        $direction = $request->get('direction', 'asc');
        $searchTerm = $request->input('searchTerm');
        $userId = Auth::user()->id;
        $TicketCusId = Customer::where('user_id',$userId)->value('CustomerId'); 
        
        $scheduleQuery = Schedule::query();
        if (!empty($searchTerm)) {
            $scheduleQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('schedules');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $scheduleQuery->orderBy($sort, $direction);
        $scheduleQuery = Schedule::whereHas('asset', function ($query) use ($TicketCusId) {
            $query->where('AssetCusId', $TicketCusId);
        })->paginate(10);
        $schedules =  $scheduleQuery;

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('maintenance.scheduled', compact('schedules', 'nextDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($AssetId): View
    {
        $asset = Asset::Where('AssetId', $AssetId)->first();
        return view('maintenance.create',compact('asset'), [
            'staffs' => DB::table("staffs")->where("role", '3')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $input = $request->all();
        Schedule::create($input);
        return redirect()->route('maintenance.scheduled')->with('success','Maintenance is Scheduled Successfully');
    }

    public function scheduled(Request $request): view
    {
        $sort = $request->get('sort', 'ScheduleId');
        $direction = $request->get('direction', 'asc');
        $searchTerm = $request->input('searchTerm');

        $scheduleQuery = Schedule::query();
        if (!empty($searchTerm)) {
            $scheduleQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('schedules');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $scheduleQuery->orderBy($sort, $direction);
        $schedules =  $scheduleQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('maintenance.scheduled', compact('schedules', 'nextDirection'));
    }

    public function updateStatus($ScheduleId, $status): RedirectResponse
    {
        $statusMappings = [
            'completed' => 1,
            'scheduled' => 2,
            'unscheduled' => 3,
        ];

        $schedule = Schedule::findOrFail($ScheduleId);
        $schedule->MaintenanceStatusId = $statusMappings[$status] ?? null;
        $schedule->save();

        return redirect()->route('maintenance.scheduled');
    }
    public function mySchedule(Request $request): view
    {
        $sort = $request->get('sort', 'ScheduleId');
        $direction = $request->get('direction', 'asc');
        $searchTerm = $request->input('searchTerm');
        $userId = Auth::user()->id;
        $TicketStaffId = Staff::where('user_id',$userId)->value('StaffId');

        $scheduleQuery = Schedule::query();
        if (!empty($searchTerm)) {
            $scheduleQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('schedules');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $scheduleQuery->orderBy($sort, $direction);
        $scheduleQuery->where('AssignedId', $TicketStaffId)->get();
        $schedules =  $scheduleQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('maintenance.scheduled', compact('schedules', 'nextDirection'));
    }

    public function statusUpdate($ScheduleId, $status): RedirectResponse
    {
        $statusMappings = [
            'completed' => 1,
            'scheduled' => 2,
            'unscheduled' => 3,
        ];

        $schedule = Schedule::findOrFail($ScheduleId);
        $schedule->MaintenanceStatusId = $statusMappings[$status] ?? null;
        $schedule->save();

        return redirect()->route('myschedule');
    }

    /**
     * Display the specified resource.
     */
    public function show($ScheduleId): View
    {
        $schedule = Schedule::Where('ScheduleId', $ScheduleId)->first();
        return view('maintenance.show', compact('schedule'), [
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($ScheduleId): View
    {
        $schedule = Schedule::Where('ScheduleId', $ScheduleId)->first();
        return view('maintenance.edit', compact('schedule'), [
            'staffs' => DB::table("staffs")->where("role", '3')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $ScheduleId): RedirectResponse
    {
        $input = $request->all();
        $ScheduleId->update($input);
        return redirect()->route('maintenance.scheduled')
            ->with('success','Maintenance schedule is Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ScheduleId): RedirectResponse
    {
        $schedule = Schedule::where('ScheduleId', $ScheduleId)->first();
        $schedule->delete();
        return redirect()->route('maintenance.scheduled')->with('success','Schedule of Maintenance is Deleted Successfully.');
    }
}
