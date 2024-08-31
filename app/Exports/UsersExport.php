<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithColumnWidths, WithHeadings
{
    public function __construct(protected $users, public string $heading)
    {
    }

    public function collection()
    {
        return collect($this->users);
    }

    public function headings(): array
    {
        return [
            [$this->heading],
            [],
            [
                'fullname',
                'username',
                'email',
                'password_field',
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 40,
            'D' => 25,
        ];
    }
}
