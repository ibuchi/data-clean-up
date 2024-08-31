<?php

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    // return ['Laravel' => app()->version()];


    $users = User::all();

    $file_heading = 'Onikan General Hospital' . ' - ' . $users->first()->created_at->toDayDateTimeString();

    $users = $users->map(
        function ($user) {
            return [
                'fullname' => $user->fullname ?? '',
                'username' => $user->username ?? '',
                'email' => $user->email ?? '',
                'password_field' => $user->password_field ?? '',
            ];
        }
    );

    return Excel::download(new UsersExport($users, $file_heading), "Onikan-General-Hospital-Users-Records.xlsx");
});

require __DIR__.'/auth.php';
