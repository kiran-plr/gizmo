<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Mail\CreateUserMail;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUserAction
{
    public function execute(array $data)
    {
        DB::beginTransaction();
        try {
            $pass = Str::random(8);
            $data['password'] = Hash::make($pass);

            $user = User::create($data);

            $user->roles()->attach(AppHelper::USER['id']);
            $userPerm = Permission::getUserPermissionsForAssign();
            $user->permissions()->sync($userPerm);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;

        }

        /** Send User Verification Email */
        Mail::to($user->email)->send(new CreateUserMail($user, $pass));

        return $user;
    }
}
