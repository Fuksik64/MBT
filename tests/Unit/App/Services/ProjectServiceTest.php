<?php

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\assertDatabaseCount;


it('can store project', function () {
    $project = Project::factory()->make()->toArray();


    app()->make(ProjectService::class)->store($project);

    assertDatabaseCount(Project::class, 1);
});


it('can delete project', function () {
    $project = Project::factory()->create();

    app()->make(ProjectService::class)->destroy($project);

    assertDatabaseCount(Project::class, 0);
});

it('can edit project', function () {
    $project = Project::factory()->create();

    $data = Project::factory()->make(
        [
            'name' => 'test',
            'start_date' => now()->subDay()->toDateString(),
            'end_date' => now()->addDay()->toDateString()
        ]
    )->toArray();

    app()->make(ProjectService::class)->update($project, $data);


    $project->refresh();
    expect($project)
        ->name->toBe('test')
        ->start_date->toBe($data['start_date'])
        ->end_date->toBe($data['end_date']);

});

it('can send email', function () {
    Mail::fake();
    $project = Project::factory()->create();

    $service = app()->make(ProjectService::class);
    $service->sendMail($project, 'test@test.com');

    Mail::assertSent(\App\Mail\ProjectEmail::class);
});
