<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersCreateValidation;
use App\Http\Requests\Users\UsersUpdateValidation;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
class UsersController extends Controller
{
    private const USERS_FOR_PAGINATION = 10;

    public function index(Request $request)
    {
        //$users = User::orderBy('id','desc')->paginate(self::USERS_FOR_PAGINATION);
        $query = User::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))) {
            $query->role($value)->get();
        }

        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];

        $roles = Role::all()->pluck('name', 'id')->toArray();

        $users = $query->paginate(self::USERS_FOR_PAGINATION);
        return view('admin.users.index',[
            'users' => $users,
            'statuses' => $statuses,
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];
        $roles = Role::all()->pluck('name', 'id')->toArray();
        return view('admin.users.create',compact(['statuses','roles']));
    }

    public function store(UsersCreateValidation $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => User::STATUS_WAIT,
            'password' => bcrypt($request->password),
            'verify_token' => Str::random(16),
        ]);
        if (isset($request->role) && auth()->user()->hasPermissionTo('set roles')) {
            $role = Role::find($request->role);
            $user->assignRole($role); //Assigning role to user
        }
        return redirect()->route('admin.users.show', $user)->with('success','The New User successfully created');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.users.edit', compact(['user','statuses','roles']));
    }

    public function update(UsersUpdateValidation $request, User $user)
    {
        $roles = [];
        if (isset($request->roles)) {
            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        }
        //Checking if a role was selected
        if (count($roles) > 0 && auth()->user()->hasPermissionTo('set roles')) {
            $user->syncRoles($roles); //Assigning role to user
        }
//        $request->status ? $request->status = 'active' : $request->status = 'wait';
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->roles,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        flash('User destroyed')->warning();
        return redirect()->route('admin.users.index');
    }
}
