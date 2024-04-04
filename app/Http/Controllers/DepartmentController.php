<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('departments.index', [
            'departments' => Department::orderBy('DepartmentId')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // $input = $request->all();
        $input = $request->validate([
            'DepartmentName' => "required|string|max:255"
        ]);
        Department::create($input);

        return redirect()->route('departments.index')
            ->with('success','New Department is Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($DepartmentId): View
    {
        $department = Department::where('DepartmentId', $DepartmentId)->first();
        return view('departments.show', [
            'department' => $department
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($DepartmentId): View
    {
        $department = Department::where('DepartmentId', $DepartmentId)->first();
        return view('departments.edit', [
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $DepartmentId): RedirectResponse
    {
        $department = Department::where('DepartmentId', $DepartmentId)->first();
        $input = $request->all();

        $department->update($input);

        if (empty($request->from)) {
            return redirect()->route('departments.index')
                ->with('success','Department is Updated Successfully.');
        } else {
            return redirect()->route('departments.edit')
                ->with('error','Somrthing went Wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($DepartmentId): RedirectResponse
    {
        $department = Department::where('DepartmentId', $DepartmentId)->first();
        $department->delete();
        return redirect()->route('departments.index')->with('success','Department is Deleted Successfully.');
    }
}
