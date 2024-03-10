<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Role;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function totalEmployees()
    {
        $totalEmployees = Employee::count();
        return response()->json(['total_employees' => $totalEmployees]);
    }

    public function totalRoles()
    {
        $totalRoles = Role::count();
        return response()->json(['total_roles' => $totalRoles]);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $role = new Role();
        $role->name = request('name');
        $role->save();

        return response()->json(['message' => 'Role created successfully'], 201);
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if (!$role)
        {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->delete();
        return response()->json(['message' => 'Role deleted']);
    }
}
