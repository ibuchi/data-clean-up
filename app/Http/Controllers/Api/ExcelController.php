<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkUploadRequest;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function store(BulkUploadRequest $request)
    {
        return response()->json([
            'message' => 'uploaded successfully!'
        ]);
    }
}
