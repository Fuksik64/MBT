<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreRequest;
use App\Services\ProjectService;

class ProjectCreateController extends Controller
{
    public function __invoke()
    {
        return view('projects-create');
    }

    public function store(ProjectService $service, ProjectStoreRequest $request)
    {
        $data = $request->validated();
        $service->store($data);
        return back();

    }
}
