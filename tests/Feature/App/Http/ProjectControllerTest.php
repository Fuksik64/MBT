<?php

use App\Http\Middleware\Authenticate;
use App\Models\Project;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;
use function Pest\Laravel\withoutMiddleware;

beforeEach(fn() => withoutMiddleware(Authenticate::class));

it('can store project', function () {
    $project = Project::factory()->make()->toArray();

    post(route('projects.create.store'), $project);
    assertDatabaseCount(Project::class, 1);
});

it('can delete project', function () {
    $project = Project::factory()->create();

    delete(route('projects.destroy', $project->id));
    assertDatabaseCount(Project::class, 0);
});

it('can edit project', function () {
    $project = Project::factory()->create();

    $data = Project::factory()
        ->make(['name' => 'test'])
        ->toArray();
    patch(route('projects.update', $project->id), $data);

    $project->refresh();
    expect($project)->name->toBe('test');
});

it('can store valid file attached to project', function () {
    $data = Project::factory()
        ->make(['file' => UploadedFile::fake()->image('avatar.jpg')])
        ->toArray();
    post(route('projects.create.store'), $data);

    $project = Project::firstOrFail();
    expect($project->file_path)->not->toBeNull();

});

