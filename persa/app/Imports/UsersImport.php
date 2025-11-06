<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UsersImport implements ToModel, WithHeadingRow, WithStartRow, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 1;
    }

    private function mapRowKeys(array $row): array
    {
        $normalized = [];
        foreach ($row as $k => $v) {
            $key = mb_strtolower(trim((string) $k));
            $key = preg_replace('/\s+/', '_', $key);
            $normalized[$key] = is_null($v) ? null : trim((string) $v);
        }

        $documentKeys = ['document', 'documento', 'dni', 'identificacion', 'identificación', 'id'];
        $fullnameKeys = ['fullname', 'full_name', 'name', 'nombre', 'nombres', 'apellidos'];
        $emailKeys = ['email', 'correo', 'correo_electronico', 'correo_electrónico', 'correo electrónico', 'mail'];

        $getFirst = function(array $keys) use ($normalized) {
            foreach ($keys as $k) {
                if (array_key_exists($k, $normalized) && $normalized[$k] !== null && $normalized[$k] !== '') {
                    return $normalized[$k];
                }
            }
            return null;
        };

        $document = $getFirst($documentKeys);
        $fullname = $getFirst($fullnameKeys);
        $email = $getFirst($emailKeys);

        if (empty($document) || empty($email) || empty($fullname)) {
            $values = array_values($row);
            $flatten = array_map(function($v){ return is_null($v) ? null : trim((string)$v); }, $values);

            if (empty($email)) {
                foreach ($flatten as $cell) {
                    if ($cell !== null && $cell !== '' && filter_var($cell, FILTER_VALIDATE_EMAIL)) {
                        $email = $cell;
                        break;
                    }
                }
            }

            if (empty($document)) {
                foreach ($flatten as $cell) {
                    if ($cell === null || $cell === '') continue;
                    if ($email !== null && $cell === $email) continue;
                    if (preg_match('/^[\dA-Za-z\-\_]{4,}$/', $cell)) {
                        $document = $cell;
                        break;
                    }
                }
            }

            if (empty($fullname)) {
                foreach ($flatten as $cell) {
                    if ($cell === null || $cell === '') continue;
                    if ($cell === $email || $cell === $document) continue;
                    $fullname = $cell;
                    break;
                }
            }
        }

        return [
            'document' => $document,
            'fullname' => $fullname,
            'email'    => $email,
        ];
    }

    public function model(array $row)
    {
        $allEmpty = true;
        foreach ($row as $cell) {
            if (!is_null($cell) && trim((string)$cell) !== '') {
                $allEmpty = false;
                break;
            }
        }
        if ($allEmpty) {
            return null;
        }

        $mapped = $this->mapRowKeys($row);

        $headers = ['document','fullname','email'];
        $isHeaderRow = true;
        foreach ($headers as $h) {
            if (!isset($mapped[$h]) || strtolower(trim((string)$mapped[$h])) !== $h) {
                $isHeaderRow = false;
                break;
            }
        }
        if ($isHeaderRow) {
            Log::info('UsersImport: fila de encabezado detectada y omitida');
            return null;
        }

        if (empty($mapped['document']) || empty($mapped['email'])) {
            $rowValues = array_map(function($v){ return is_null($v) ? '' : trim((string)$v); }, array_values($row));
            Log::error('UsersImport: fila inválida detectada', ['detected_values' => $rowValues, 'mapped' => $mapped]);
            throw ValidationException::withMessages([
                'import_row' => [
                    'Falta "document" o "email" en una fila. Valores detectados: ' . implode(' | ', $rowValues) .
                    '. Asegure encabezados: Documento, Nombre, Email (o coloque valores en columnas esperadas).'
                ]
            ]);
        }

        $forcedStatus = 'ACTIVO';
        $forcedRoleId = 2;

        return new User([
            'document' => $mapped['document'],
            'fullname' => $mapped['fullname'] ?? null,
            'email'    => $mapped['email'],
            'role_id'  => $forcedRoleId,
            'status'   => $forcedStatus,
            'password' => Hash::make($mapped['document']),
        ]);
    }
}