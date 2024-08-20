<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $contacts = Contact::orderBy('name', 'asc')->get();
        return response()->json([
            'contacts' => $contacts
        ],200);
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json([
            'contact' => $contact
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request, Contact $contact): JsonResponse
    {

        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $contact->profile_picture = $imagePath;
        }

        $contact->save();
        return response()->json([
            'contact' => $contact
        ],201);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact): JsonResponse
    {

        if ($request->hasFile('profile_picture')) {

            $file = $request->file('profile_picture');
            $filePath = $file->store('profile_pictures', 'public');

        } else {
            $filePath = $contact->profile_picture;
        }

        $contact->update([
            'name' => $request->input('name'),
            'phone'=> $request->input('phone'),
            'email'=> $request->input('email'),
            'profile_picture' => $filePath
        ]);

        return response()->json([
            'contact' => $contact
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'status' => true,
            'message' => "apagado com sucesso",
        ],200);
    }
}
