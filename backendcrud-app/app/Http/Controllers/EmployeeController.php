<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    
        protected $employee;
        public function __construct(){
            $this->employee = new Employee();
            
        }
    public function index()
    {
        try {
            return response()->json($this->employee->all(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        try {
            $employee = $this->employee->create($request->all());
            return response()->json($employee, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

   public function reorderEmployees()
{
    $employees = Employee::orderBy('id')->get();
    $id = 1;

    foreach ($employees as $employee) {
        $employee->id = $id;
        $employee->save();
        $id++;
    }

    return response()->json(['message' => 'Employees reordered successfully']);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $employee = $this->employee->find($id);
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $employee = $this->employee->find($id);
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
            $employee->update($request->all());
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = $this->employee->find($id);
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
            $employee->delete();
            return response()->json(['message' => 'Employee deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
