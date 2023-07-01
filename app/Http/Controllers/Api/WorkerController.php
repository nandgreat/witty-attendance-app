<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Worker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WorkerController extends BaseController
{

    public function addWorker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:workers',
            'department_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            $user = Worker::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'worker_code' => "" . rand(1111, 9999),
                'email' => $request->email,
                'department_id' => $request->department_id,
                'image_url' => $request->image_url,
            ]);


            return $this->sendResponse($user, 'Worker Added successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function updateWorker(Request $request, $workerId)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'department_id' => 'required',
            'image_url' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            $worker = Worker::find($workerId);

            if ($worker) {

                $worker->first_name = $request->first_name;
                $worker->last_name = $request->last_name;
                $worker->email = $request->email;
                $worker->department_id = $request->department_id;
                $worker->image_url = $request->image_url;
                $worker->save();
            }

            return $this->sendResponse($worker, 'Worker Fetched successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function allWorkers(Request $request)
    {


        try {
            $workers = DB::table('workers')->join('departments', 'departments.id', '=', 'workers.department_id')->select('workers.*', 'departments.department_name')->get();
            return $this->sendResponse($workers, 'Workers Fetched successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // Process or store the uploaded file as needed
                // Generate a unique filename for the image
                $filename = time() . '.' . $file->getClientOriginalExtension();

                // Move the uploaded image to the public storage folder
                $file->move(public_path('images'), $filename);

                // Get the URL of the uploaded image
                $imageUrl = asset('images/' . $filename);

                return response()->json(['status' => true, 'message' => 'File uploaded successfully', 'data' => ['image_url' => "images/$filename"]]);
            }

            return response()->json(['status' => false, 'message' => 'No file uploaded'], 400);
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
