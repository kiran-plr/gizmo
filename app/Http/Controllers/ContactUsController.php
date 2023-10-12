<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Mail\ContactUSEmail;
use App\Mail\FreeQuoteMail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('frontend.contact-us');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3,max:30',
            'email' => 'required|email:rfc,dns,strict,spoof,filter|min:3,max:30',
            'message' => 'required|string|min:10,max:500',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'name.required' => 'Please enter your name',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 30 characters',
            'name.min' => 'Name must be at least 3 characters',
            'email.required' => 'Please enter your email',
            'email.email' => 'Email must be a valid email',
            'message.required' => 'Please enter your message',
            'message.string' => 'Message must be a string',
            'message.max' => 'Message must be less than 500 characters',
            'message.min' => 'Message must be at least 10 characters',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Please verify that you are not a robot',
        ]);

        $data = $request->all();
        ContactUs::create($data);
        // Send Mail
        Mail::to(env('ADMIN_NOTIFICATIONS_EMAIL'))->send(new ContactUSEmail($data));
        return redirect()->back()->with('success', 'Thank you for contacting us. We will get back to you soon');
    }

    public function storeInquiry(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3,max:30',
            'email' => 'required|email:rfc,dns,strict,spoof,filter|min:3,max:30',
            'phone' => 'required',
            'message' => 'required|string|min:10,max:500',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'name.required' => 'Please enter your name',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 30 characters',
            'name.min' => 'Name must be at least 3 characters',
            'phone.required' => 'Please enter your phone',
            'email.required' => 'Please enter your email',
            'email.email' => 'Email must be a valid email',
            'message.required' => 'Please enter your message',
            'message.string' => 'Message must be a string',
            'message.max' => 'Message must be less than 500 characters',
            'message.min' => 'Message must be at least 10 characters',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Please verify that you are not a robot',
        ]);

        $data = $request->all();
        ContactUs::create($data);
        // Send Mail
        Mail::to(env('ADMIN_NOTIFICATIONS_EMAIL'))->send(new ContactUSEmail($data));
        return redirect()->back()->with('success', 'Thank you for contacting us. We will get back to you soon');
    }

    public function submitQuoteForm(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|min:3,max:30',
            'last_name' => 'required|string|min:3,max:30',
            'company_or_school_name' => 'required|string|min:3,max:30',
            'email' => 'required|email:rfc,dns,strict,spoof,filter|min:3,max:30',
            'phone' => 'required',
            'description' => 'required|string|max:500',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'first_name.required' => 'Please enter first name',
            'first_name.string' => 'First Name must be a string',
            'first_name.max' => 'First Name must be less than 30 characters',
            'first_name.min' => 'First Name must be at least 3 characters',
            'last_name.required' => 'Please enter last name',
            'last_name.string' => 'Last Name must be a string',
            'last_name.max' => 'Last Name must be less than 30 characters',
            'last_name.min' => 'Last Name must be at least 3 characters',
            'phone.required' => 'Please enter your phone',
            'email.required' => 'Please enter your email',
            'email.email' => 'Email must be a valid email',
            'description.required' => 'Please enter brief description',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description must be less than 500 characters',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Please verify that you are not a robot',
        ]);

        $data = $request->all();
        // Send Mail
        Mail::to(env('ADMIN_NOTIFICATIONS_EMAIL'))->send(new FreeQuoteMail($data, 'admin'));
        Mail::to($data['email'])->send(new FreeQuoteMail($data, 'users'));

        return redirect()->route('corporate-recycling.thankyou')->with('success', 'Thank you for contacting us. We will get back to you soon');
    }

    public function thankYouPage()
    {
        return view('frontend.partials.cr-thankyou');
    }
}
