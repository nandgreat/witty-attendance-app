<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends BaseController
{


    public function allDepartments(Request $request)
    {

        $keyInserted = Department::all();

        return $this->sendResponse($keyInserted, 'Departments fetched successfully.');
    }
}
