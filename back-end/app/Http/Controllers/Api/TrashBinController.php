<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Exception;
use Illuminate\Http\JsonResponse;


class TrashBinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try{
            $trashedContacts = Contact::onlyTrashed()->get();
            return response()->json([
                'status' => true,
                'contacts' => $trashedContacts
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'errorMsg' => 'Erro ao recuperar contatos'
            ], 500);

        }
    }

    public function restore(Contact $contact): JsonResponse
    {

        try {

            $contact->restore();
            return response()->json([
                'status' => true,
                'message' => 'Contato restaurado com sucesso'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'errorMsg' => 'Erro ao restaurar contato'
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
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
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        try {
            $contact->forceDelete();
            return response()->json([
                'status' => true,
                'message' => 'O contato foi apagado permanentemente',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errorMsg' => 'Erro ao apagar contato'
            ], 500);
        }
    }
}
