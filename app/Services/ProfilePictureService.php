<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class ProfilePictureService
{
    public function updateProfilePicture($file, $oldFile, $removePfp): mixed
    {
        if ($removePfp){
            $this->deleteProfilePicture($oldFile);
            return null;

        }

        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            $this->deleteProfilePicture($oldFile);

        }

        $newFile = $this->setProfilePicture($file);

        return $newFile;

    }

    public function setProfilePicture($file): mixed
    {
        return $file->store('profile_pictures', 'public');

    }

    public function deleteProfilePicture($filePath): void
    {
        Storage::disk('public')->delete($filePath);

    }

}

