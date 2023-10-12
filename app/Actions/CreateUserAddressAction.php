<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Session;

class CreateUserAddressAction
{
    public function execute(array $data)
    {
        $user = User::getUser();
        $address = $user->addresses()->where('status', '1')->first();
        $add = UserAddress::updateOrCreate(['id' => $address->id ?? null], $data);
    }
}
