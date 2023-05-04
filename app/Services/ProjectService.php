<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Models\Project;
use Illuminate\Support\Arr;

class ProjectService
{
    public function store(array $data)
    {
        $data = array_merge($data, ['file_path' => $this->storeFile($data)]);
        return Project::create($data);
    }

    protected function storeFile(array $data): ?string
    {
        if (!Arr::get($data, 'file')) {
            return null;
        }

        File::ensureDirectoryExists(storage_path('public/projects'));

        return $data['file']->store('public/projects');
    }


    public function destroy(Project $project): void
    {
        $project->delete();
    }

    public function update(Project $project, array $data): void
    {
        $project->update($data);
    }
}
