<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissionsTrait;

    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'phone',
        'avatar',
        'active',
        'is_verified',
        'last_login_at',
        'settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getCreateValidationRule($type = null)
    {
        $validation = [
            'email' => 'required|email:rfc,dns,strict,spoof,filter',
            'first_name' => 'required|string|alpha|max:30',
            'last_name' => 'required|string|alpha|max:30',
        ];
        if ($type == 'vendor') {
            unset($validation['recaptcha']);
        }
        return $validation;
    }

    public static function getCreateValidationMessage()
    {
        $message = [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            // 'email.unique' => 'This email address is already exist. Please sign in or change an email address.',
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'first_name.string' => 'Please enter a valid first name.',
            'last_name.string' => 'Please enter a valid last name.',
            'first_name.alpha' => 'Please enter a valid first name.',
            'last_name.alpha' => 'Please enter a valid last name.',
        ];
        return $message;
    }

    public function getFirstNameAttribute()
    {
        $firstName = head(explode(' ', $this->attributes['name']));
        return $firstName;
    }

    public function getLastNameAttribute()
    {
        $lastName = last(explode(' ', $this->attributes['name']));
        return $lastName;
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'user_location_assigns', 'user_id', 'location_id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }

    public function payoutMethod()
    {
        return $this->hasOne(UserPayoutMethod::class, 'user_id');
    }

    public function getLastLoginAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getAvatarAttribute($value)
    {
        if ($value && \File::exists(public_path('/users/avatar/' . $value))) {
            return asset('/users/avatar/' . $value);
        } else {
            return asset('assets/images/users/avatar-4.jpg');
        }
    }

    public function getRoleAttribute($value)
    {
        return $this->roles()->first();
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function getSettingsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getShipmentCountAttribute()
    {
        return Shipment::where('location_id', auth()->user()->location->id)->count();
    }

    public function getLocationCountAttribute()
    {
        return auth()->user()->locations()->count();
    }

    public static function getUser()
    {
        if (AppHelper::isUser()) {
            return auth()->user();
        }
        if (Session::has('user')) {
            return Session::get('user');
        }
    }
}
