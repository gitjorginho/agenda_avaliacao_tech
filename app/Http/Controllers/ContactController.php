<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all( "id","name", "email","telephone","message");
        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {

        $file = $request->file->store('file');

        $contact = Contact::create(array_merge($request->all(), ['file' => $file,'ip'=>$request->ip()]));
        Mail::send(new ContactMail($contact));

        return response()->json($contact);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        
        if($request->hasFile('file')){
            $file = $request->file->store('file');
              $request->merge(['file'=>$file]);

              $contact->update(array_merge($request->all(),['file'=>$file,'ip'=>$request->ip()]));
        }else{
            unset($request->file);
            $contact->update(array_merge($request->all(),['ip'=>$request->ip()]));
        }
         
        
        
        Mail::send(new ContactMail($contact));
        
        return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json($contact);
    }
}
