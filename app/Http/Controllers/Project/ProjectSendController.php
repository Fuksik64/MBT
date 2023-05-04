<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectSendController extends Controller
{
    public function __invoke(Project $project, ProjectService $service, Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email'
        ]);
        $service->send($project, $data['email']);
        return back();
    }
}
