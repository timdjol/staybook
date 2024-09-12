<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Currency;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::get();
        return view('auth.manager.contacts.index', compact('contacts'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('auth.manager.contacts.form', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $params = $request->all();

        $contact->update($params);
        session()->flash('success', 'Контакты обновлены');
        return redirect()->route('manager.contacts.index');
    }

}
