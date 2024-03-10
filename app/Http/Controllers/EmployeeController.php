<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function searchByName(Request $request)
    {
        $name = $request->input('name');
        $employees = Employee::where('name', 'LIKE', "%$name%")->get();
        return response()->json($employees);
    }

    public function searchById($id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return response()->json(['message' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($employee);
    }

    public function assignRole(Request $request, $id)
    {

        $request->validate([
            'role' => 'required|in:manager,developer,design,scrum master'
        ]);

        $employee = Employee::find($id);
        if (!$employee)
        {
            return response()->json(['message' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }

        $employee->role = request('role');
        $employee->save();

        return response()->json(['message' => 'Role assigned successfully'], Response::HTTP_OK);
    }

    public function index(Request $request)
    {

       logger($request->user());
        $employees = Employee::all();
        if($employees->isEmpty())
        {
            return response()->json(['message' => 'No Employee record found'], Response::HTTP_OK);
        }

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'role' => 'required'
        ]);

        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->update($request->all());
        return response()->json($employee);
    }


    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();
        return response()->json(['message' => 'Employee deleted']);
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:employed, fired'
        ]);

        $employee = Employee::find($id);
        if(!$employee)
        {
            return response()->json(['message' => 'Employee not found'], Response::HTTP_NOT_FOUND);
        }

        $employee->status = request('status');
        $employee->save();

        return response()->json(['message' => 'Employee status updated successfully'], Response::HTTP_OK);
    }
}
