<?php

namespace App\Imports;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnFailure,
    ShouldQueue,
    WithBatchInserts,
    WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $name = $this->sanitizeName($row);

        return new User([
            'fullname' => $name,
            'username' => $this->getUserName($name),
            'email' => $this->getEmail($name),
            'password_field' => $this->getPasswordField($name),
            'role' => '3',
            'department' => 'All',
            'status' => 1,
            'password' => $this->getPasswordField($name)
        ]);
    }

    /**
     * Specify batch size.
     *
     * @return int
     *
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Read spreadsheet in chunks
     *
     * @return int
     *
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    //TODO: Handle failed product uploads
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function sanitizeName(array $row = null): string
    {
        $name = trim($row['name']);

        $name = preg_replace('/\s+/', ' ', $name);

        return strtoupper($name);
    }

    /**
     * Generate an email from the name.
     *
     * @param string $name
     * @return string
     */
    public function getEmail(string $name): string
    {
        $nameParts = explode(' ', strtolower($name));
        if (count($nameParts) >= 2) {
            return $nameParts[0][0] . $nameParts[1] . '@randlegeneralhospital.com';
        }

        return $nameParts[0] . '@randlegeneralhospital.com';
    }

    public function getUserName(string $name): string
    {
        $nameParts = explode(' ', strtolower($name));

        return $nameParts[0][0] . $nameParts[1];
    }

    public function getPasswordField(string $name)
    {
        $nameParts = explode(' ', $name);

        return '@' . $nameParts[0][0] . strtolower($nameParts[1]) . '123';
    }
}
