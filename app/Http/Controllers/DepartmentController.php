<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Department;
use Exception;

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
        try {
            Department::create($input);
            return redirect()->route('departments.index')
                ->with('success', 'New Department is Created Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
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
        try {
            $department = Department::where('DepartmentId', $DepartmentId)->first();
            $input = $request->all();
            $department->update($input);
            return redirect()->route('departments.index')
                ->with('success', 'Department is Updated Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($DepartmentId): RedirectResponse
    {
        try {
            $department = Department::where('DepartmentId', $DepartmentId)->first();
            $department->delete();
            return redirect()->route('departments.index')->with('success', 'Department is Deleted Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}
