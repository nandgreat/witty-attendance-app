<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Worker;
use App\Models\WorkerAttendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends BaseController
{

    public function takeAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], $validator->errors());
        }

        try {

            $event = Event::whereDate('start_time', '=', Carbon::now())->first();

            if (!$event) {
                return $this->sendError('No Event found for today', []);
            }

            $worker =  Worker::where('worker_code', $request->worker_code)->first();;

            if (!$worker) {
                return $this->sendError('Invalid worker code. Please enter a valid Worker code', []);
            }

            $checkattendance =  WorkerAttendance::where(['worker_id' => $worker->id, 'event_id' => $event->id])->first();

            if ($checkattendance) {
                return $this->sendError("Attendance already marked", []);
            }


            $attendance =  WorkerAttendance::create(['worker_id' => $worker->id, 'event_id' => $event->id, 'time_in' => Carbon::now()]);

            return $this->sendResponse($attendance, 'Attendance Marked Successfully');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
