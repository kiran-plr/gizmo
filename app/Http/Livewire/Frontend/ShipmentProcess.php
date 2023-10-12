<?php

namespace App\Http\Livewire\Frontend;

use App\Actions\CreateUserAction;
use App\Actions\CreateUserAddressAction;
use App\Helpers\AppHelper;
use App\Models\Country;
use App\Models\User;
use Livewire\Component;
use App\Models\UserAddress;
use App\Models\UserPayoutMethod;
use App\Shipment\Shipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShipmentProcess extends Component
{
    use Shipment;
    public $user;
    public $email;
    public $userData;
    public $shipping;
    public $countryId;
    public $shipmentType;
    public array $data = [];
    public $shipmentData = [];
    public bool $shipmentTypeDisplay = false;
    public bool $personalInformationDisplay = true;
    public $payoutMethod;
    public $userPayoutMethodId;
    public $addressType;
    public $loginArr;
    public $recaptcha;

    public function mount($data)
    {
        $this->data = $data;
        $this->countryId = '1';
        $this->shipping['country_id'] = '1';
        $this->addressType = 'new';
        $this->getUser();
        $this->getData();
    }

    /**
     * Return Country Code
     */
    public function countryCode($data)
    {
        $this->shipping['phone_code'] = $data['iso2'];
    }

    /**
     * Return Countries
     */
    public function getCountriesProperty()
    {
        return Country::all();
    }

    /**
     * Set Country Id
     */
    public function setCountry($countryId)
    {
        $this->countryId = $countryId;
        $this->shipping['country_id'] = $countryId;
    }

    /**
     * Return Country
     */
    public function getCountryProperty()
    {
        return Country::find($this->countryId);
    }

    /**
     * Return User
     */
    public function getUser()
    {
        $this->userData = User::getUser();
        if (AppHelper::isUser()) {
            $this->user['email'] = $this->userData->email;
            $this->user['first_name'] = $this->userData->first_name;
            $this->user['last_name'] = $this->userData->last_name;

            $this->shipping['email'] = $this->userData->email;
            $this->shipping['first_name'] = $this->userData->first_name;
            $this->shipping['last_name'] = $this->userData->last_name;
        } elseif ($this->user) {
            $this->shipping['email'] = $this->user['email'];
            $this->shipping['first_name'] = $this->user['first_name'];
            $this->shipping['last_name'] = $this->user['last_name'];
        }
    }

    /**
     * Store User Information
     *
     */
    public function storeUserInformation()
    {
        $this->getUser();

        /** Validate Personal Info */
        $this->validate($this->personalInfoRules(), $this->personalInfoRuleMessage());

        /** Validate Shipping info if Address New */
        if ($this->shippingInfoForm && $this->addressType == 'new' && !auth()->check()) {
            $this->validate(array_merge($this->recaptchaRule(), $this->shippingRules()), array_merge($this->recaptchaRuleMessage(), $this->shippingRuleMessage()));
        } elseif ($this->shippingInfoForm && $this->addressType == 'new') {
            $this->validate($this->shippingRules(), $this->shippingRuleMessage());
        }

        $this->storeData();
    }

    /**
     * Store Data
     *
     */
    public function storeData()
    {
        DB::beginTransaction();
        try {
            /** Create User If Not available */
            if (!isset($this->userData->id)) {
                /** @var CreateUserAction $action */
                $action = app(CreateUserAction::class);
                $this->user['name'] = $this->user['first_name'] . ' ' . $this->user['last_name'];
                $user = $action->execute($this->user);
                $this->userData = $user;

                Session::put('user', $user);

                $this->shipping['email'] = $this->user['email'];
                $this->shipping['first_name'] = $this->user['first_name'];
                $this->shipping['last_name'] = $this->user['last_name'];
            }

            /** Update existing user address if available or create new */
            if ($this->addressType == 'new') {
                $this->shipping['name'] = $this->shipping['first_name'] . ' ' . $this->shipping['last_name'];
                unset($this->shipping['first_name'], $this->shipping['last_name']);
                $this->shipping['user_id'] = $this->userData->id;

                /** @var CreateUserAddressAction $action */
                $action = app(CreateUserAddressAction::class);
                $action->execute($this->shipping);
            }

            DB::commit();

            $this->personalInformationDisplay = false;
            $this->shipmentTypeDisplay = true;
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }




    /**
     * Get the validation rules for the recaptcha.
     *
     * @return array
     */
    public function recaptchaRule()
    {
        return ['recaptcha' => 'required|captcha'];
    }

    /**
     * Get the validation rules for the recaptcha.
     *
     * @return array
     */
    public function recaptchaRuleMessage()
    {
        return [
            'recaptcha.required' => 'Please verify that you are not a robot.',
            'recaptcha.captcha' => 'Please verify that you are not a robot.'
        ];
    }

    /**
     * Get the validation rules for the personal information.
     *
     * @return array
     */
    public function personalInfoRules()
    {
        return collect(User::getCreateValidationRule())
            ->mapWithKeys(
                fn ($item, $key) => ['user.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the personal information.
     *
     * @return array
     */
    public function personalInfoRuleMessage()
    {
        return collect(User::getCreateValidationMessage())
            ->mapWithKeys(
                fn ($item, $key) => ['user.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules for the shipping information.
     *
     * @return array
     */
    public function shippingRules()
    {
        return collect(UserAddress::getCreateValidationRule())
            ->mapWithKeys(
                fn ($item, $key) => ['shipping.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the shipping information.
     *
     * @return array
     */
    public function shippingRuleMessage()
    {
        return collect(UserAddress::getCreateValidationMessage())
            ->mapWithKeys(
                fn ($item, $key) => ['shipping.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Select Shipment Type
     */
    public function selectShipmentType($type)
    {
        $this->shipmentType = $type;
        if ($type == 1) {
            $this->payoutMethod = '';
            $this->email = '';
        }
    }

    /**
     * Continue with selected shipment type
     */
    public function submitShipmentType()
    {
        if ($this->shipmentType == 2) {
            if ($this->payoutMethod != 'paypal') {
                $this->validate([
                    'payoutMethod' => 'required',
                ], [
                    'payoutMethod.required' => 'Please select payout method',
                ]);
            } else {
                $this->validate([
                    'payoutMethod' => 'required',
                    'email' => 'required|email:rfc,dns,strict,spoof,filter',
                ], [
                    'payoutMethod.required' => 'Please select payout method',
                    'email.required' => 'Please enter paypal email address',
                    'email.email' => 'Please enter valid email address',
                ]);
            }
        }

        $this->payoutMethod = $this->shipmentType == 1 ? 'digital_payment' : $this->payoutMethod;

        $this->shipmentData['shipment_type'] = $this->shipmentType;
        $this->shipmentData['payoutMethod'] = $this->payoutMethod;

        $userPayoutMethod = UserPayoutMethod::updateOrCreate(['id' => $this->userPayoutMethodId], [
            'user_id' => $this->userData->id,
            'email' => $this->email,
            'type' => $this->payoutMethod,
            'name' => ucfirst($this->payoutMethod),
        ]);

        $this->userPayoutMethodId = $userPayoutMethod->id;

        $this->shipmentData['userPayoutMethodId'] = $this->userPayoutMethodId;

        Session::put('shipmentData', $this->shipmentData);

        if ($this->shipmentType == 1) {
            return redirect()->route('locations');
        } elseif ($this->shipmentType == 2) {
            return redirect()->route('shipment-review');
        }
    }

    public function getData()
    {
        $this->shipmentData = Session::get('shipmentData') ?? [];
        $this->userPayoutMethodId = $this->shipmentData['userPayoutMethodId'] ?? '';
    }

    public function selectUserPayoutMethod($method)
    {
        $this->payoutMethod = $method;
    }

    public function setAddressType($type)
    {
        $this->addressType = $type;
    }

    public function getAddressProperty()
    {
        $userData = User::where('email', ($this->user && isset($this->user['email']) ? $this->user['email'] : ''))->first();

        $address = $userData ? $userData->addresses()->where('status', '1')->first() : null;
        if ($address == null && $this->addressType == 'old') {
            $this->addressType = 'new';
        }
        return $address;
    }

    public function login()
    {
        $this->validate([
            'loginArr.email' => 'required|email:rfc,dns,strict,spoof,filter|exists:users,email',
            'loginArr.password' => 'required',
            'recaptcha' => 'required|captcha'
        ], [
            'loginArr.email.required' => 'Please enter your email address.',
            'loginArr.email.email' => 'Please enter a valid email address.',
            'loginArr.email.unique' => 'This email address is already exist. Please sign in or change an email address.',
            'loginArr.password.required' => 'Please enter password.',
            'recaptcha.required' => 'Please verify that you are not a robot.',
            'recaptcha.captcha' => 'Please verify that you are not a robot.'
        ]);

        if (Auth::attempt(['email' => $this->loginArr['email'], 'password' => $this->loginArr['password']])) {
            AppHelper::notify('Successfully logged in', 'success');
            $this->dispatchBrowserEvent('loginSuccess');
        } else {
            AppHelper::notify('Error Incorrect email address and/or password.Please enter correct login details', 'error');
        }
    }

    public function getLoginFormProperty()
    {
        $userData = User::where('email', ($this->user && isset($this->user['email']) ? $this->user['email'] : ''))->first();
        if ($userData && !auth()->check()) {
            $this->loginArr['email'] = $this->user['email'];
            return true;
        } else {
            return false;
        }
    }

    public function getShippingInfoFormProperty()
    {
        $userData = User::where('email', ($this->user && isset($this->user['email']) ? $this->user['email'] : ''))->first();

        if ($userData && !auth()->check()) {
            return false;
        }
        return true;
    }

    public function render()
    {
        return view('livewire.frontend.shipment-process');
    }
}
