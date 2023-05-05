<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ProjectService
{
    public function sendMail(Project $project, string $email): void
    {
        Mail::to($email)->send(new \App\Mail\ProjectEmail($project));
    }

    public function export(Collection $data, string $type)
    {
        return match ($type) {
            'pdf' => $this->exportPdf($data),
            'xlsx' => $this->exportXlsx($data),
        };
    }

    protected function exportPdf(Collection $data)
    {
        $mpdf = new Mpdf();
        $mpdf->WriteHTML('
            <table class="table bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th>Nazwa projektu</th>
                        <th> Data rozpoczęcia</th>
                        <th> Data zakończenia</th>
                        <th>Grafika</th>
                    </tr>
                </thead>
                <tbody>'
        );
        foreach ($data as $project) {
            $image = '';
            if ($project->file_path) {
                $filePath = public_path('/storage/' . $project->file_path);
                $image = base64_encode(file_get_contents($filePath));
                $image = '<img src="data:' . mime_content_type($filePath) . ';base64,' . $image . '" width="100" height="100" />';
            }

            $mpdf->WriteHTML('
                <tr>
                    <td>' . $project->name . '</td>
                    <td>' . $project->start_date . '</td>
                    <td>' . $project->end_date . '</td>
                    <td>' . $image . '</td>
                </tr>'
            );
        }
        $mpdf->WriteHTML('</tbody></table>');
        return $mpdf->Output();
    }

    protected function exportXlsx(Collection $data)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Nazwa');
        $activeWorksheet->setCellValue('B1', 'Data rozpoczęcia');
        $activeWorksheet->setCellValue('C1', 'Data zakończenia');

        foreach ($data as $key => $project) {
            $activeWorksheet->setCellValue('A' . ($key + 2), $project->name);
            $activeWorksheet->setCellValue('B' . ($key + 2), $project->start_date);
            $activeWorksheet->setCellValue('C' . ($key + 2), $project->end_date);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/projects.xlsx'));

        return storage_path('app/public/projects.xlsx');
    }

    public function store(array $data)
    {
        $data = array_merge($data, ['file_path' => $this->storeFile($data)]);
        return Project::create($data);
    }

    protected function storeFile(array $data, ?Project $project = null): ?string
    {
        if (!Arr::get($data, 'file')) {
            return $project->file_path ?? null;
        }

        File::ensureDirectoryExists(storage_path('app/public/projects'));
        return str_replace('public/', '', $data['file']->store('public/projects'));
    }


    public function destroy(Project $project): void
    {
        $project->delete();
    }

    public function update(Project $project, array $data): void
    {
        $data = array_merge($data, ['file_path' => $this->storeFile($data, $project)]);
        $project->update($data);
    }
}
