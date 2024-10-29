<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    protected $profilePictureService;

    public function __construct(ProfilePictureService $profilePictureService)
    {
        $this->profilePictureService = $profilePictureService;
    }

    public function createContact($request): array
    {
        if ($request->file('profile_picture')){
            $profilePicture = $this->profilePictureService->setProfilePicture(
                $request->file('profile_picture')
            );

            $contact = Contact::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'profile_picture' => $profilePicture
            ]);

        } else {
            $contact = Contact::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        }

        $data = [
            'contact' => $contact,
            'message' => 'Contato adicionado com sucesso'
        ];

        return $data;

    }

    public function updateContact($request, Contact $contact): array
    {
        if ($request->file('profile_picture') || $request->remove_pfp){
            $newPfp = $this->profilePictureService->updateProfilePicture(
                $request->file('profile_picture'),
                $contact->profile_picture,
                $request->remove_pfp
            );

            $contact->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'profile_picture' => $newPfp
            ]);

        } else {
            $contact->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email')
            ]);

        }

        if ($contact->wasChanged()) {
            $data = [
                'contact' => $contact,
                'message' => 'Contato atualizado com sucesso'
            ];
            return $data;

        } else {
            $data = [
                'contact' => $contact,
                'message' => 'Nenhuma alteração foi realizada'
            ];
            return $data;
        }
    }

    public function deleteContact($contact): array
    {
        $contact->delete();

        $data = [
            'contact' => $contact,
            'message' => 'Contato apagado com sucesso'
        ];

        return $data;

    }

}
