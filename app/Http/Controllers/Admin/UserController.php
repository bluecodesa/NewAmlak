<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Broker;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users =  User::getAdmins();
        return view('Admin.users.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('type', 'admin')->get();

        return view('Admin.users.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $request_data = $request->except('roles', 'password');
        $request_data['password'] = bcrypt($request->password);
        $role = Role::find($request->roles);
        $request_data['is_admin'] = true;
        $user =   User::create($request_data);
        $user->assignRole($role->name);
        return redirect()->route('Admin.users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('Admin.users.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        if ($user->hasRole('App_SuperAdmin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        $roles = Role::where('type', 'admin')->get();
        return view('Admin.users.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // Extract name, email, and password fields from the request data
        $request_data = $request->only(['name', 'email', 'password']);

        // Hash the password if it's included in the request data
        if ($request->password) {
            $request_data['password'] = bcrypt($request->password);
        } else {
            $request_data['password'] = $user->password;
        }


        $user->update($request_data);

        if ($request->roles) {
            $role = Role::find($request->roles);
            $user->syncRoles([$role->name]); // Use syncRoles to replace all roles with the new one
        }

        return redirect()->route('Admin.users.index')
            ->withSuccess('Update successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('App_SuperAdmin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('Admin.users.index')
            ->withSuccess('User is deleted successfully.');
    }
}
