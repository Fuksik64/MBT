<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectEditController extends Controller
{
    public function __invoke(Project $project, Request $request)
    {
        return view('project-edit', ['project' => $project]);
    }

    public function update(Project $project, ProjectService $service, ProjectStoreRequest $request)
    {
        $data = $request->validated();
        $service->update($project, $data);
        return redirect()->route('projects.list');
    }
}
