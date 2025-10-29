<?php

namespace App\Imports;

namespace App\Imports;

use App\Models\Course;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourseImport implements ToModel, WithHeadingRow
{
    private bool $validatedHeaders = false;

    public function model(array $row)
    {
        if (!$this->validatedHeaders) {
            $this->validateHeaders(array_keys($row));
            $this->validatedHeaders = true;
        }

        if (!isset($row['number_group']) || empty($row['number_group'])) {
            return null;
        }

        return new Course([
            'number_group' => $row['number_group'] ?? $row['ficha'] ?? null,
            'shift'        => $row['shift'] ?? $row['jornada'] ?? null,
            'trimester'    => $row['trimester'] ?? $row['trimestre'] ?? null,
            'year'         => $row['year'] ?? $row['año'] ?? null,
            'status'       => $row['status'] ?? $row['estado'] ?? 'ACTIVO',
            'career_id'    => $row['career_id'] ?? $row['programa'] ?? 1,
        ]);
    }

    private function validateHeaders($headers)
    {
        $requiredHeaders = ['number_group', 'shift', 'trimester', 'year', 'status', 'career_id'];

        $missing = array_diff($requiredHeaders, $headers);

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'headers' => ['Faltan las siguientes columnas en el Excel: ' . implode(', ', $missing)],
            ]);
        }
    }
}