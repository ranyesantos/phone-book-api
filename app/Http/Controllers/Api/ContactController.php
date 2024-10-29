<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Exception;


class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {

            $contacts = Contact::orderBy('name', 'asc')->get();
            return response()->json([
                'status' => true,
                'contacts' => $contacts
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'errorMsg' => 'Erro ao recuperar contatos'
            ], 500);

        }
    }

    public function show(Contact $contact): JsonResponse
    {
        try {

            return response()->json([
                'status' => true,
                'contact' => $contact
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'errorMsg' => 'Erro ao exibir contato'
            ], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request): JsonResponse
    {
        try {

            $data = $this->contactService->createContact($request);

            return response()->json([
                'contact' => $data['contact'],
                'message' => $data['message']
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'contact' => null,
                'message' => 'Erro ao adicionar contato'
            ], 500);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        try {
            $data = $this->contactService->updateContact($request, $contact);

            return response()->json([
                'contact' => $data['contact'],
                'message' => $data['message']
            ], 200);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'errorMsg' => 'Erro ao atualizar contato'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        try {
            $data = $this->contactService->deleteContact($contact);
            return response()->json([
                'status' => true,
                'contact' => $data['contact'],
                'message' => $data['message']
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errorMsg' => 'Erro ao apagar contato'
            ], 500);
            
        }
    }
}
