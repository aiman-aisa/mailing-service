<?php

namespace App\Http\Controllers;

use App\Models\MailDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function index()
    {
        $mailDetails = MailDetail::all();

        return view('welcome', compact(['mailDetails']));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required',
        ]);

        MailDetail::create([
            'email' => $request->email,
            'message' => $request->message,
        ]);

        $formattedMessage = "\nEmail To: " . $request->email . "\n\n\nMessage: " . $request->message;

        // Send the email using Mailtrap
        Mail::raw($formattedMessage, function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Mailing Service');
        });

        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
