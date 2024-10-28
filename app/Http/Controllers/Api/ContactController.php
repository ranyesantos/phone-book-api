<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use App\Services\ProfilePictureService;
use Exception;


class ContactController extends Controller
{
    private $profilePictureService;

    public function __construct(ProfilePictureService $profilePictureService)
    {
        $this->profilePictureService = $profilePictureService;
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

            $contact = Contact::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'profile_picture' => $this->profilePictureService->setProfilePicture($request)
            ]);

            return response()->json([
                'contact' => $contact,
                'message' => 'Contato adicionado com sucesso'
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errorMsg' => 'Erro ao adicionar contato'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact): JsonResponse
    {
        try {

            $contact->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'profile_picture' => $this->profilePictureService->updateProfilePicture($request, $contact)
            ]);

            if ($contact->wasChanged()) {
                return response()->json([
                    'contact' => $contact,
                    'message' => 'Contato atualizado com sucesso'
                ], 200);
            } else {
                return response()->json([
                    'contact' => $contact,
                    'message' => 'Nenhuma alteração foi feita no contato'
                ], 200);
            }

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
            $contact->delete();
            return response()->json([
                'status' => true,
                'message' => 'Contato apagado com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errorMsg' => 'Erro ao apagar contato'
            ], 500);
        }
    }
}
