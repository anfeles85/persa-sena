<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Career;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class CourseImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    private $errors = [];
    private $skipped = [];
    private $imported = 0;


    private bool $validatedHeaders = false;

    public function model(array $row)
    {
        // Validar encabezados la primera vez
        if (!$this->validatedHeaders ?? false) {
            $this->validateHeaders(array_keys($row));
            $this->validatedHeaders = true;
        }

        // Evitar filas vacías
        if (empty($row['number_group'])) {
            return null;
        }

        // Buscar programa (career) por nombre
        $career = Career::where('name', $row['career'] ?? $row['programa'] ?? null)->first();

        if (!$career) {
            $this->skipped[] = [
                'ficha'   => $row['number_group'] ?? 'Desconocido',
                'programa' => $row['career'] ?? $row['programa'] ?? 'No especificado'
            ];
            return null; 
        }


        $this->imported++;

        return new Course([
            'number_group' => $row['number_group'] ?? $row['ficha'] ?? null,
            'shift'        => $row['shift'] ?? $row['jornada'] ?? null,
            'trimester'    => $row['trimester'] ?? $row['trimestre'] ?? null,
            'year'         => $row['year'] ?? $row['año'] ?? null,
            'status'       => 'ACTIVO',
            'career_id'    => $career->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'number_group' => 'required|numeric|min:1',
            'shift'        => 'required|string|max:50',
            'trimester'    => 'required|string|max:10',
            'year'         => 'required|numeric|min:2000',
            'career'       => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'number_group.required' => 'La ficha es obligatoria.',
            'shift.required'        => 'La jornada es obligatoria.',
            'trimester.required'    => 'El trimestre es obligatorio.',
            'year.required'         => 'El año es obligatorio.',
            'career.required'       => 'El programa es obligatorio.',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $row = $failure->row();
            $attribute = $failure->attribute();
            $error = $failure->errors()[0];

            if (!isset($this->errors[$attribute])) {
                $this->errors[$attribute] = [
                    'rows' => [],
                    'message' => $error
                ];
            }
            $this->errors[$attribute]['rows'][] = $row;
        }
    }

    private function validateHeaders($headers)
    {
        $requiredHeaders = ['number_group', 'shift', 'trimester', 'year', 'career'];
        $missing = array_diff($requiredHeaders, $headers);

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'headers' => ['Faltan las siguientes columnas en el Excel: ' . implode(', ', $missing)],
            ]);
        }
    }

    public function getGroupedErrors()
    {
        return $this->errors;
    }

    public function getSkipped()
    {
        return $this->skipped;
    }

    public function getImported()
    {
        return $this->imported;
    }
}
