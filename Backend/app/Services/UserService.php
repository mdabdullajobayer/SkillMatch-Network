<?php

namespace App\Services;

use App\Helpers\UploadImage;
use App\Models\Project;
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

    public function getFeed($userId)
    {
        // Fetch user and their skills
        $user = User::with('skills')->find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $userSkills = $user->skills->pluck('name')->toArray();
        // Fetch all projects with their skills
        $projects = Project::with('skills')->get();

        // Calculate match percentage for each project
        $projectsWithMatch = $projects->map(function ($project) use ($userSkills) {
            $projectSkillNames = $project->skills->pluck('name')->toArray();
            $matchingSkills = array_intersect($userSkills, $projectSkillNames);
            $matchPercentage = count($projectSkillNames) > 0
                ? (count($matchingSkills) / count($projectSkillNames)) * 100
                : 0;

            return [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'start_date' => $project->start_date,
                'status' => $project->status,
                'match_percentage' => round($matchPercentage, 2),
                'match_skills' => $matchingSkills
            ];
        });

        return response()->json($projectsWithMatch);
    }
}
