<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Student;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function export()
    {

        $filePath = storage_path('app/public/students.csv');

        // Retrieve data from the database
        $students = Student::all(['name', 'grade', 'phno', 'address', 'date_of_birth'])->toArray();
        // Create CSV file
        SimpleExcelWriter::create($filePath)
            ->addHeader(['Name', 'Grade', 'Phone', 'Address', 'Date of Birth'])
            ->addRows($students);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    public function import(Request $request)
    {
        $file = $request->file('file');
        $tempFilePath = $file->storeAs('temp', 'imported_file.csv');
        $filePath = storage_path('app/' . $tempFilePath);

        // Ensure the file is a CSV
        if (!$file || $file->getClientOriginalExtension() !== 'csv') {
            return response()->json(['error' => 'Please upload a valid CSV file'], 400);
        }

            // Process the file
            SimpleExcelReader::create($filePath)
            ->getRows()
            ->each(function (array $row) {
                Student::create([
                    'name' => $row['Name'],
                    'grade' => $row['Grade'],
                    'phno' => $row['Phone'],
                    'address' => $row['Address'],
                    'date_of_birth' => $row['Date of Birth'],
                ]);
            });
        
        return response()->json(['message' => 'Import successful']);
    }

}
