<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Telephone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::with('telephones')->get();
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
    
        $contact = Contact::create($request->all());

        $telephones = json_decode($request->telephones);
        
        if(!empty($telephones)){
            foreach ($telephones as $number) {
            Telephone::create(['telephone' => $number->telephone, 'contact_id' => $contact->id]);
        }
    }
            $contact = Contact::with('telephones')->find($contact->id);
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
        
        $contact->update($request->all());
        $telephones = Telephone::where('contact_id', $contact->id)->get();

        foreach ($telephones as $telephone) {
            $telephone->delete();
        }
        
       $telephones = json_decode($request->telephones);
         
        foreach ($telephones as $number) {
                if(!empty($number->telephone)){
                    Telephone::create(['telephone' => $number->telephone, 'contact_id' => $contact->id]);    
                }
                
        }

        $contact = Contact::with('telephones')->find($contact->id);
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
        $telephones = Telephone::where('contact_id', $contact->id)->get();
        foreach ($telephones as $telephone) {
            $telephone->delete();
        }

        $contact->delete();
        
        
        Log::info('Contato Apagado:',[$contact]);
        
        return response()->json($contact);
    }
}
