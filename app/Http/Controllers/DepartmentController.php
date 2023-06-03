<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends BaseController
{


    public function allDepartments(Request $request)
    {
        $keyInserted = Department::all();

        return $this->sendResponse($keyInserted, 'Departments fetched successfully.');
    }


    public function addDepartment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'department_name' => 'required|unique:departments',
            'department_short_name' => 'required',
            'keys_taken' => 'required',
            'keys_available' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], $validator->errors());
        }

        $keyInserted = Department::create([
            'department_name' => $request->department_name,
            'department_short_name' => $request->department_short_name,
            'keys_taken' => $request->keys_taken,
            'keys_available' => $request->keys_available
        ]);

        return $this->sendResponse($keyInserted, 'Department Added successfully.');
    }
}
