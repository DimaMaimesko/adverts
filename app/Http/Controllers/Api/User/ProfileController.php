<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ProfileEditValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\Profile\ProfileService;
use App\Http\Resources\User\ProfileResource;
class ProfileController extends Controller
{
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request)
    {
        $user = $request->user();
        return new ProfileResource($user);
    }

    public function update(ProfileEditValidation $request)
    {
        $this->service->edit($request->user()->id, $request);

        $user = User::findOrFail($request->user()->id);

        return new ProfileResource($user);
    }
}
