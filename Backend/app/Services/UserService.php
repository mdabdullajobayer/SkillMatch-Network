<?php

namespace App\Services;

use App\Helpers\UploadImage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function updateUserProfile(array $data, int $userId)
    {
        // Start a transaction
        return DB::transaction(function () use ($data, $userId) {
            // Retrieve the user
            $user = User::find($userId);
            if (!$user) {
                throw new \Exception('User not found.');
            }
            // Handle image upload
            if (isset($data['image'])) {
                $uploadedImagePath = UploadImage::uploadImage($data['image'], 'user_images', $user->profile);
                $user->profile = $uploadedImagePath;
            }

            // Update user details
            $user->name = $data['name'] ?? $user->name;
            $user->description = $data['description'] ?? $user->description;

            // Save user updates
            $user->save();

            // Update skills
            if (isset($data['skills'])) {
                // Remove existing skills
                $user->skills()->delete();

                // Add new skills
                foreach ($data['skills'] as $skill) {
                    $user->skills()->create([
                        'name' => $skill['name'],
                        'description' => $skill['description'] ?? null,
                    ]);
                }
            }
            // Load updated user with skills
            return $user->load('skills');
        });
    }
}
