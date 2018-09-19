<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersCreateValidation;
use App\Http\Requests\Users\UsersUpdateValidation;
use App\Models\User;
use Illuminate\Support\Str;
class UsersController extends Controller
{
    private const USERS_FOR_PAGINATION = 10;

    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(self::USERS_FOR_PAGINATION);
        return view('admin.users.index',['users' => $users]);
    }

    public function create()
    {
        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];
        return view('admin.users.create',compact('statuses'));
    }

    public function store(UsersCreateValidation $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'password' => bcrypt($request->password),
            'verify_token' => Str::random(16),
        ]);
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
        return view('admin.users.edit', compact(['user','statuses']));
    }

    public function update(UsersUpdateValidation $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        flash('User destroyed')->warning();
        return redirect()->route('admin.users.index');
    }
}
