<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        $searchTerm = $request->input('searchTerm');
        $userQuery = User::query();

        if (!empty($searchTerm)) {
            $userQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('users');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $userQuery->orderBy($sort, $direction);
        $users = $userQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('users.index', compact('users', 'nextDirection'), [
            // 'users' => User::orderBy('id')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        // $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->with('success','New Staff is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $user = User::where('id', $id)->first();
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = User::where('id', $id)->first();
        // Check Only Admin can update his own Profile
        if ($user->hasRole('Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $userId = Auth::user()->id;
        dd($userId);
        $user = User::where('id', $userId)->first();
        dd($user);
        $input = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email|max:250',
            'password' => 'string|min:8|confirmed',
        ]);

        $user->update($input);

        if (empty($request->from)) {
            return redirect()->route('users.index')
                ->with('success','User is updated successfully.');
        } else {
            return redirect()->route('profile')
                ->with('success','Profile is updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::where('id', $id)->first();
        // About if user is Admin or User ID belongs to Auth User
        if ($user->hasRole('Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')->with('success','User is deleted successfully.');
    }
}
