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
                $query->orWhereHas('assettype', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetTypeName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('department', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('DepartmentName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('organization', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('OrganizationName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('Staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('servicetype', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('ServiceDesc', 'LIKE', '%' . $searchTerm . '%');
                });
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
        $TicketCusId = Customer::where('user_id', $userId)->value('CustomerId');

        $scheduleQuery = Schedule::query();
        if (!empty($searchTerm)) {
            $scheduleQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('schedules');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('maintenancestates', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StatusName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('asset', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('Staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
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
        return view('maintenance.create', compact('asset'), [
            'staffs' => DB::table("staffs")->where("role", '3')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'AssetId' => 'required',
            'AssignesId' => 'required|integer',
            'NumberOfServices' => 'required|integer',
            'ServiceDate.*' => 'required|date',
            'Instruction' => 'required|string|max:255',
        ]);

        try {
            foreach ($validatedData['ServiceDate'] as $date) {
                Schedule::create([
                    'AssetId' => $validatedData['AssetId'],
                    'AssignesId' => 'required|integer',
                    'ServiceDate' => $date,
                    'Instruction' => $validatedData['Instruction'],
                ]);
            }
            return redirect()->route('maintenance.scheduled')->with('success', 'Maintenance for your asset is scheduled successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
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
                $query->orWhereHas('maintenancestates', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StatusName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('asset', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('Staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
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
        $TicketStaffId = Staff::where('user_id', $userId)->value('StaffId');

        $scheduleQuery = Schedule::query();
        if (!empty($searchTerm)) {
            $scheduleQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('schedules');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('maintenancestates', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StatusName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('asset', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('Staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $scheduleQuery->orderBy($sort, $direction);
        $scheduleQuery = Schedule::whereHas('asset', function ($query) use ($TicketStaffId) {
            $query->where('AssetManagedBy', $TicketStaffId);
        })->paginate(10);
        $schedules =  $scheduleQuery;

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
        return view('maintenance.show', compact('schedule'), []);
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
    public function update(Request $request, $ScheduleId): RedirectResponse
    {
        $validatedData = $request->validate([
            'AssetId' => 'required',
            'AssignesId' => 'required|integer',
            'NumberOfServices' => 'required|integer',
            'ServiceDate' => 'required|date',
            'Instruction' => 'required|string|max:255',
        ]);

        try {
            $schedule = Schedule::where('ScheduleId', $ScheduleId)->first();
            $schedule->update([
                'AssetId' => $validatedData['AssetId'],
                'AssignesId' => 'required|integer',
                'ServiceDate' => $validatedData['ServiceDate'],
                'Instruction' => $validatedData['Instruction'],
            ]);

            return redirect()->route('maintenance.scheduled')->with('success', 'Your scheduled Maintenance is updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ScheduleId): RedirectResponse
    {
        try {
            $schedule = Schedule::where('ScheduleId', $ScheduleId)->first();
            $schedule->delete();
            return redirect()->route('maintenance.scheduled')->with('success', 'Schedule of Maintenance is Deleted Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}
