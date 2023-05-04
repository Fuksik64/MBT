<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(ProjectService $service, ProjectStoreRequest $request)
    {
        $data = $request->validated();
        $service->store($data);
        return redirect()->route('projects.index');
    }

    public function update(Project $project, ProjectService $service, Request $request)
    {
        $data = $request->all();
        $service->update($project, $data);
        return redirect()->route('projects.index');
    }

    public function destroy(Project $project, ProjectService $service, Request $request)
    {
        $service->destroy($project);
        return redirect()->route('projects.index');
    }
}
