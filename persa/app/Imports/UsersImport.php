<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    private bool $validatedHeaders = false;

    public function model(array $row)
    {
        // Traducción estricta del campo 'status' (solo acepta activo/inactivo en ES o EN)
        $statusRaw = isset($row['status']) ? trim(strtolower($row['status'])) : '';
        if (in_array($statusRaw, ['active', 'activo'])) {
            $row['status'] = 'ACTIVO';
        } elseif (in_array($statusRaw, ['inactive', 'inactivo'])) {
            $row['status'] = 'INACTIVO';
        } else {
            throw ValidationException::withMessages([
            'status' => ["Valor de status inválido: '{$row['status']}'. Debe ser 'activo'/'inactivo' (ES) o 'active'/'inactive' (EN)."],
            ]);
        }
        // Validar los encabezados solo una vez
        if (!$this->validatedHeaders) {
            $this->validateHeaders(array_keys($row));
            $this->validatedHeaders = true;
        }
        // Verificar si el usuario ya existe por 'documento'
        if (!isset($row['document']) || empty($row['document'])) {
            return null;
        }

        // Verificar si el usuario ya existe por 'documento' o 'email'
        $existingUser = User::where('document', $row['document'])
            ->orWhere('email', $row['email'])
            ->first();
        // Si el usuario ya existe, no crear uno nuevo
        if ($existingUser) {
            return null;
        }
        //Hash de la contraseña usando el valor del 'documento'
        $hashedPassword = Hash::make($row['document']);

        // utiliza un valor predeterminado de 2 si role_id no está presente o está vacío
        $role_id = (int) (isset($row['role_id']) && $row['role_id'] !== '' ? $row['role_id'] : 2);

        // Crear un nuevo usuario
        return new User([
            'document' => $row['document'],
            'fullname' => $row['fullname'] ?? null,
            'email' => $row['email'],
            'role_id' => $role_id,
            'status' => $row['status'] ?? 'ACTIVO',
            'password' => $hashedPassword,
        ]);
    }

    private function validateHeaders($headers)
    {
        // make role_id optional so imports without that column use a default value
        $requiredHeaders = ['document', 'fullname', 'email', 'status'];

        $missing = array_diff($requiredHeaders, $headers);
        $missing = array_diff($requiredHeaders, $headers);

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'headers' => ['Faltan las siguientes columnas en el Excel: ' . implode(', ', $missing)],
            ]);
        }
    }
}
