<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->header('id');
        return $this->projectService->getAllProjects($user_id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->header('id');
        $data = $request->all();
        return $this->projectService->createProject($data, $user_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Project $project)
    {
        $user_id = $request->header('id');
        return $this->projectService->getProjectById($project->id, $user_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        return $this->projectService->updateProject($project, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        return $this->projectService->deleteProject($project);
    }
}
