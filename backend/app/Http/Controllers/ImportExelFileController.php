<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUsers;
use Illuminate\Support\Facades\Storage;

class ImportExelFileController extends Controller
{
  
    ///https://larachamp.com/how-to-import-excel-file-to-database-in-laravel/
    public function import(Request $request)
    {

        $file = $request->file('file');

        if (!$file) {
            return response()->json([
                'message' => 'No file uploaded'
            ], 400);
        }
        $filePath = Storage::putFile('files', $file);
        
        Excel::import(new ImportUsers, storage_path('app/' . $filePath));

        Storage::delete($filePath);

        return response()->json([
            'message' => 'import successfully',
            'data' => $filePath
        ]);
    }
}
