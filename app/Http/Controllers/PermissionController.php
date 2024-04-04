<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
class PermissionController extends Controller
{
    // public function __construct()
    // // {
    // //     $this->middleware('auth');
    // //     $this->middleware('permission:create-permission|edit-permission|delete-permission', ['only' => ['index','show']]);
    // //     $this->middleware('permission:create-permission', ['only' => ['create','store']]);
    // //     $this->middleware('permission:edit-permission', ['only' => ['edit','update']]);
    // //     $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    // // }

    public function index(): View
    {
        return view('permissions.index', [
            'permissions' => Permission::orderBy('id','DESC')->paginate(15)
        ]);
    }

    public function create(): View
    {
        return view('permissions.create', [
            'permissions' => Permission::select('id','name')->get(),
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $this->validate(request(), [
            'name' => 'required|unique:permissions'
        ]);
        $permissions = Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')
                ->with('success','New Permission is Created Successfully.');
    }


    public function edit(string $id)
    {
        $permission = Permission::findById($id);
        return view('permissions.edit', compact('permission'));
    }


    public function update(Request $request, string $id)
    {
        $this->validate(request(), [
            'name' => 'required|unique:permissions,name,'.$id
        ]);
        $permission = Permission::findById($id);
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('permissions.index')
                ->with('success','Permission is updated successfully.');
    }


    public function destroy(string $id)
    {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect()->route('permissions.index')
                ->with('success','Permission is deleted successfully.');

    }
}
