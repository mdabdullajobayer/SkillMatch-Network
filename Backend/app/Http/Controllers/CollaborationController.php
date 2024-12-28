<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    public function createCollaboration(Request $request)
    {
        $userId = $request->header('id');

        // Fetch user skills
        $user = User::with('skills')->find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $userSkills = $user->skills->pluck('name')->toArray();

        // Fetch project skills
        $project = Project::with('skills')->find($request->project_id);
        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }
        $projectSkills = $project->skills->pluck('name')->toArray();

        // Calculate match percentage
        $matchingSkills = array_intersect($userSkills, $projectSkills);
        $matchPercentage = count($projectSkills) > 0
            ? (count($matchingSkills) / count($projectSkills)) * 100
            : 0;

        // Check if match percentage is at least 80%
        if ($matchPercentage < 80) {
            return response()->json([
                'error' => 'Collaboration not allowed. User skills match only ' . round($matchPercentage, 2) . '%.',
            ], 403);
        }

        // Create collaboration
        $collaboration = Collaboration::create([
            'project_id' => $request->project_id,
            'user_id' => $userId,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Collaboration invitation sent.',
            'data' => $collaboration,
        ]);
    }
    public function getCollaborators($projectId)
    {
        $collaborators = Collaboration::where('project_id', $projectId)
            ->with('user', 'project')
            ->get();

        return response()->json($collaborators);
    }
    public function acceptCollaboration(Request $request)
    {
        try {
            $collaboration = Collaboration::where('id', $request->collaboration_id)->first();
            $collaboration->status = 'accepted';
            $collaboration->save();
            Project::where('id', $collaboration->project_id)->update(['status' => 'in_progress']);
            return response()->json(['message' => 'Collaboration accepted.', 'data' => $collaboration]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Collaboration already accepted.'], 400);
        }
    }

    public function rejectCollaboration(Request $request)
    {
        $collaboration = Collaboration::where('id', $request->collaboration_id)->first();
        $collaboration->status = 'rejected';
        $collaboration->save();
        return response()->json(['message' => 'Collaboration rejected.', 'data' => $collaboration]);
    }
}
