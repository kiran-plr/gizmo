<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('locations', 'roles')->orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrEdit($id = null)
    {
        $user = User::find($id);
        $roles = Role::where('slug', '!=', 'admin')->get();
        return view('admin.users.create', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        $validationArr = [
            'first_name' => 'required|string|alpha|min:3|max:30',
            'last_name' => 'required|string|alpha|min:3|max:30',
            'email' => 'required|email:rfc,dns,strict,spoof,filter|unique:users,email,' . $id,
            'phone' => 'required|min:6|max:30',
            'address' => 'required|string|min:6|max:70',
            'address2' => 'max:70',
            'city' => 'required|string|min:3|max:30',
            'state' => 'required|string|min:2|max:30',
            'zip' => 'required|digits_between:5,10',
        ];

        if (!$id) {
            $validationArr = array_merge(
                $validationArr,
                [
                    'password' => 'required|min:4|max:30',
                    'confirm_password' => 'required|same:password',
                ]
            );
        }
        $user = User::find($id);
        if ($id == null || $user->hasRole('user')) {
            $validationArr = array_merge(
                $validationArr,
                ['role' => 'required|exists:roles,id']
            );
        }

        $this->validate($request, $validationArr);

        $data = $request->all();

        DB::beginTransaction();
        try {
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            $data['password'] = Hash::make($request->password);
            unset(
                $data['first_name'],
                $data['last_name'],
                $data['confirm_password']
            );

            $user = User::updateOrCreate(['id' => $id ?? null], $data);

            if ($request->role) {
                $user->roles()->sync($request->role);
            }

            if ($user->hasRole('vendor')) {
                $userPerm = Permission::getVendorPermissionsForAssign();
            } else {
                $userPerm = Permission::getUserPermissionsForAssign();

                $address = $user->addresses()->where('status', '1')->first();
                $data['user_id'] = $user->id;
                $data['country_id'] = 1;
                $data['apartment'] = $data['address2'];

                UserAddress::updateOrCreate(['id' => $address->id ?? null], $data);
            }
            $user->permissions()->sync($userPerm);

            DB::commit();

            if (!$id) {
                return redirect()->route('admin.user.index')->with('success', 'User has been created successfully.');
            }

            return redirect()->route('admin.user.index')->with('success', 'User has been updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role->slug != 'admin') {
            $user->delete();
        }
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    /**
     * userLogin through admin panel
     */
    public function userLogin(Request $request)
    {
        $user = User::find($request->id);
        Auth::login($user);
        $role = $user->role->slug;
        switch ($role) {
            case AppHelper::ADMIN['slug']:
                session()->flash('success', 'Successfully logged in!');
                return redirect()->route('admin.dashboard');
                break;
            case AppHelper::VENDOR['slug']:
                session()->flash('success', 'Successfully logged in!');
                return redirect()->route('vendor.dashboard');
                break;
            default:
                session()->flash('success', 'Successfully logged in!');
                return redirect()->route('user.dashboard');
                break;
        }
    }

    /**
     * user logout only for admin panel
     */
    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('admin.dashboard');
    }
}
