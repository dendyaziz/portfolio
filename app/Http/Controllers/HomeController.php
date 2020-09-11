<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactMe;
use App\ContactMessage;
use App\Jobs\SendEmail;
use App\Mail\ContactMessageMail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            return $this->successResponse();
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'message' => ['required', 'min:20', 'string'],
            ]);

            if ($validator->fails()) {
                return $this->failureResponse($validator->errors(), 400);
            }

            $contact = Contact::firstOrCreate($request->only(['email']));
            $contactMessage = ContactMessage::create($request->only(['email, message']));
            $contactMessage->contact()->save($contact);

            $mail = new ContactMessageMail($contactMessage);
            dispatch(new SendEmail($mail, env('MAIL_TO_ADDRESS')));

            return $this->successResponse();
        } catch (\Exception $e) {
            Log::info($e);

            return $this->failureResponse($e->getMessage());
        }
    }
}
