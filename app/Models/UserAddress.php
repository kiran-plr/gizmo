<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country_id',
        'zip',
        'latitude',
        'longitude',
        'type',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCreateValidationRule()
    {
        return [
            'email' => 'required|email:rfc,dns,strict,spoof,filter',
            'first_name' => 'required|string|alpha|max:30',
            'last_name' => 'required|string|alpha|max:30',
            'phone' => 'required|numeric|digits_between:4,10',
            'address' => 'required|max:70,min:10',
            'apartment' => 'max:70',
            'city' => 'required|max:30,min:3',
            'state' => 'required|max:30,min:3',
            'zip' => 'required|digits_between:3,6',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    public static function getCreateValidationMessage()
    {
        return [
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter valid email address',
            'first_name.required' => 'Please enter first name',
            'first_name.string' => 'First name must be a string',
            'first_name.alpha' => 'First name must be alphabet',
            'first_name.max' => 'First name must be less than 30 characters',
            'last_name.required' => 'Please enter last name',
            'last_name.string' => 'Last name must be a string',
            'last_name.alpha' => 'Last name must be alphabet',
            'last_name.max' => 'Last name must be less than 30 characters',
            'phone.required' => 'Please enter phone number',
            'phone.numeric' => 'Phone number must be numeric',
            'phone.digits_between' => 'Phone number must be between 4 to 10 digits',
            'address.required' => 'Please enter address',
            'address.max' => 'Address must be less than 70 characters',
            'address.min' => 'Address must be at least 10 characters',
            'apartment.max' => 'Apartment must be less than 70 characters',
            'city.required' => 'Please enter city',
            'city.max' => 'City must be less than 30 characters',
            'city.min' => 'City must be at least 3 characters',
            'state.required' => 'Please enter state',
            'state.max' => 'State must be less than 30 characters',
            'state.min' => 'State must be at least 3 characters',
            'zip.required' => 'Please enter zip code',
            'zip.digits_between' => 'Zip code must be between 3 to 6 digits',
            'country_id.required' => 'Please select country',
            'country_id.exists' => 'Country does not exists',
        ];
    }
}
