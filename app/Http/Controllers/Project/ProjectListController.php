<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectListController extends Controller
{

    protected function getProjectsQuery()
    {
        return Project::query()
            ->when(request()->name, fn($q) => $q->where('name', 'like', '%' . request()->name . '%'))
            ->when(request()->start_date, fn($q) => $q->where('start_date', '>=', request()->start_date))
            ->when(request()->end_date, fn($q) => $q->where('end_date', '<=', request()->end_date));
    }

    public function __invoke()
    {
        $projects = $this->getProjectsQuery()->paginate(25);
        return view('projects-list', ['projects' => $projects]);
    }

    public function export(ProjectService $service, Request $request)
    {
        $data = $request->validate(['type' => 'required|in:pdf,xlsx']);
        $path = $service->export($this->getProjectsQuery()->get(), $data['type']);
        return response()->download($path);
    }
}
