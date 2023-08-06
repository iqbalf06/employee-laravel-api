<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::all();

        if ($employee) {
            return ApiFormatter::createApi(200, 'success', $employee);
        } else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'department' => 'required'
        ]);

        try {
            $employee = Employee::create($request->all());
            return ApiFormatter::createApi(200, 'success', $employee,);
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return ApiFormatter::createApi(200, 'success', $employee);
        } catch (Exception $error) {
            return ApiFormatter::createApi(404, 'failed');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $request->validate([
                'name' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'department' => 'required'
            ]);

            $employee->update([
                'name' => $request->name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'department' => $request->department,
            ]);

            return ApiFormatter::createApi(200, 'success', $employee);
        } catch (Exception $error) {
            return ApiFormatter::createApi(404, 'failed');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $employee->delete();

            return ApiFormatter::createApi(200, 'success', 'Employee deleted successfully.');
        } catch (Exception $error) {
            return ApiFormatter::createApi(404, 'failed');
        }
    }

    public function search($keyword)
    {
        $employee = Employee::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('department', 'like', '%' . $keyword . '%')
            ->orWhere('dob', 'like', '%' . $keyword . '%')
            ->get();

        if ($employee->isEmpty()) {
            return ApiFormatter::createApi(404, 'failed', 'No employee found.');
        }

        return ApiFormatter::createApi(200, 'success', $employee);
    }
}
