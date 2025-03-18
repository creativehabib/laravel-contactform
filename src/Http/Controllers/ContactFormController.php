<?php

namespace Habiblaravel\Contactform\Http\Controllers;

use Habiblaravel\Contactform\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Habiblaravel\Contactform\Mail\InquiryEmail;
class ContactFormController extends BaseController
{
    public function index()
    {
        return view('contactform::create');
    }

    public function store(Request $request)
    {
        // validate
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create a new contact
        $contact = Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);
        $admin_email = \config('contactform.admin_email');
        if($admin_email === null || $admin_email === ''){
            echo "The value of admin email not set";
        } else {
            Mail::to($admin_email)->send(new InquiryEmail($validated));
        }

        // Redirect or return a response
        return back()->with('success', 'Thanks for contacting us, please wait for response!!');
    }
}
