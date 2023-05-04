<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectDestroyController extends Controller
{
    public function __invoke(Project $project, ProjectService $service, Request $request)
    {
        $service->destroy($project);
        return back();

    }
}
