<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function getAllProjects($user_id)
    {
        return Project::with('skills')->where('user_id', $user_id)->get();
    }
    public function createProject($data, $user_id)
    {
        // Create the project
        $project = Project::create([
            'user_id' => $user_id,
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);

        // Attach skills to the project using many-to-many relationship
        if (!empty($data['skill_id'])) {
            $project->skills()->sync($data['skill_id']);
        }

        return $project; // Return the created project
    }

    public function getProjectById($id, $user_id)
    {
        return Project::with('skills')->find($id);
    }

    public function updateProject($project, $data)
    {
        // Update the project
        $project->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);

        // Attach skills to the project using many-to-many relationship
        if (!empty($data['skill_id'])) {
            $project->skills()->sync($data['skill_id']);
        }

        return $project; // Return the updated project
    }

    public function deleteProject($project)
    {
        // Delete the project
        $project->delete();
    }
}
