<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Exception;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('roles.index', [
            'roles' => Role::orderBy('id')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('roles.create', [
            'permissions' => Permission::select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        try {
            $role = Role::create(['name' => $request->name]);
            $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
            $role->syncPermissions($permissions);
            return redirect()->route('roles.index')
                ->with('success', 'New Role is Created Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $role = Role::where('id', $id)->first();
        $rolePermissions = Permission::join("role_has_permissions", "permission_id", "=", "id")
            ->where("role_id", $role->id)
            ->select('name')
            ->get();
        return view('roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $role = Role::where('id', $id)->first();
        if ($role->name == 'Admin') {
            abort(403, 'ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::select('id', 'name')->get(),
            'rolePermissions' => $rolePermissions,
            'roles' => Role::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, $id): RedirectResponse
    {
        $role = Role::where('id', $id)->first();
        $input = $request->only('name');
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        try {
            $role->update($input);
            $role->syncPermissions($permissions);
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }

        return redirect()->back()
            ->with('success', 'Role is Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $role = Role::where('id', $id)->first();
        if ($role->name == 'Admin') {
            abort(403, 'ADMIN ROLE CAN NOT BE DELETED');
        }
        if (Auth::user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        try {
            $role->delete();
            return redirect()->route('roles.index')
                ->with('success', 'Role is Deleted Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}
