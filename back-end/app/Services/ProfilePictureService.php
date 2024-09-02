<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePictureService
{
    public function updateProfilePicture(Request $request, $contact)
    {
        //receives actual 'profile_picture' value
        $filePath = $contact->profile_picture;

        //if a file was received, set the current picture and delete the old one
        if ($request->hasFile('profile_picture')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $file = $request->file('profile_picture');
            $filePath = $file->store('profile_pictures', 'public');

        } elseif ($request->remove_pfp) {
            //if 'remove_pfp' has a value of "true", the old picture is deleted and $filePath receives a null value
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = null;
        }

        return $filePath;
    }

    public function setProfilePicture($request)
    {
        if ($request->hasFile('profile_picture')) {
            return $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        return null;
    }

}

