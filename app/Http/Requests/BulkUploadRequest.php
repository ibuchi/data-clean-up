<?php

namespace App\Http\Requests;

use App\Imports\UsersImport;
use Illuminate\Foundation\Http\FormRequest;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv'
        ];
    }

    public function passedValidation(): void
    {
        Excel::queueImport(new UsersImport, $this->file)->allOnQueue('users-import');
    }
}
