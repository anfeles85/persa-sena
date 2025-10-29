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
        if (!$this->validatedHeaders) {
            $this->validateHeaders(array_keys($row));
            $this->validatedHeaders = true;
        }

        if (!isset($row['document']) || empty($row['document'])) {
            return null;
        }

        $existingUser = User::where('document', $row['document'])
            ->orWhere('email', $row['email'])
            ->first();

        if ($existingUser) {
            return null;
        }

        $hashedPassword = Hash::make($row['document']);

        return new User([
            'document' => $row['document'],
            'name' => $row['name'],
            'email' => $row['email'],
            'role_id' => $row['role_id'] ?? 2,
            'status' => $row['status'] ?? 'ACTIVO',
            'password' => $hashedPassword,
        ]);
    }

    private function validateHeaders($headers)
    {
        $requiredHeaders = ['document', 'name', 'email', 'role_id', 'status'];

        $missing = array_diff($requiredHeaders, $headers);

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'headers' => ['Faltan las siguientes columnas en el Excel: ' . implode(', ', $missing)],
            ]);
        }
    }
}
