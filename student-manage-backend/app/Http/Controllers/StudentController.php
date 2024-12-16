<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Auth\Events\Validated;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();
        
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->has('grade')) {
            $query->where('grade', $request->grade);
        }
        
        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc'); 
        
        // Validate sort column to prevent SQL injection
        $allowedSortColumns = ['name', 'grade'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortDirection);
        }
        
        // Pagination
        $perPage = $request->input('per_page', 10);
        
        return response()->json($query->paginate($perPage));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:10',
            'phno' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);
        
        $student = Student::create($validated);
    
        return response()->json(['message' => 'Student created successfully', 'student' => $student], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::find($id);
    
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    
        return response()->json($student);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
    
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'grade' => 'sometimes|string|max:10',
            'phno' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:255',
            'date_of_birth' => 'sometimes|date',
        ]);
    
        $student->update($validated);
    
        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);
    
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    
        $student->delete();
    
        return response()->json(['message' => 'Student deleted successfully']);
    }
        



}
