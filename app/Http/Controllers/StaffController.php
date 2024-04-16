<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'StaffId');
        $direction = $request->get('direction', 'asc');

        $searchTerm = $request->input('searchTerm');
        $staffQuery = Staff::query();

        if (!empty($searchTerm)) {
            $staffQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('staff');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('roles', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $staffQuery->orderBy($sort, $direction);
        $staffs = $staffQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('users.index', compact('staffs', 'nextDirection'), []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::get()->take(3),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'StaffName' => 'required|string|max:250',
            'mobile' => ['required', 'string', 'max:10','min:10'],
            'email' => 'required|string|email|max:250|unique:staffs,email',
            'address' => ['required', 'string', 'max:255'],
            'role' => 'required',
        ]);

        $staff = Staff::create($input);
        $staff->role = $request->role;
        return redirect()->route('users.index')
            ->with('success','New Staff is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($StaffId): View
    {
        $staff = Staff::where('StaffId', $StaffId)->first();
        return view('users.show', [
            'staff' => $staff
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($StaffId): View
    {
        $staff = Staff::where('StaffId', $StaffId)->first();
        return view('users.edit', [
            'staff' => $staff,
            'roles' => Role::get()->take(3),
            'staffRoles' => $staff->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $StaffId): RedirectResponse
    {
        $staff = Staff::where('StaffId', $StaffId)->first();
        $input = $request->validate([
            'StaffName' => 'required|string|max:250',
            'mobile' => ['required', 'string', 'max:10','min:10'],
            'email' => 'required|string|email|max:250',
            'address' => ['required', 'string', 'max:255'],
            'role' => 'required',
        ]);

        $staff->update($input);

        $staff->role = $request->role;

        if (empty($request->from)) {
            return redirect()->route('users.index')
                ->with('success','Staff is updated Successfully.');
        } else {
            return redirect()->route('users.edit')
                ->with('error','Something Went Wrong.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($StaffId): RedirectResponse
    {
        $staff = Staff::where('StaffId', $StaffId)->first();
        if ($staff->StaffId == auth()->user()->id || $staff->roles->id == auth()->user()->id) {
            abort(403, 'Staff DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $staff->delete();
        return redirect()->route('users.index')->with('success','Staff is deleted successfully.');
    }
}
