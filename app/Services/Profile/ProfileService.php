<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 11.10.2018
 * Time: 11:50
 */

namespace App\Services\Profile;


use App\Http\Requests\Users\ProfileEditValidation;
use App\Models\User;

class ProfileService
{
    public function edit($id, ProfileEditValidation $request)
    {
        $user = User::findOrFail($id);
        $oldPhone = $user->phone;
        $user->update($request->only('name','last_name','phone'));
        if ($user->phone !== $oldPhone){
            $user->unverifyPhone();
        }
    }

}