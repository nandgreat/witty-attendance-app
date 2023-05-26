<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Key;
use App\Models\KeyLog;
use App\Models\Worker;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KeyLogController extends BaseController
{
    //

    public function pickKey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_code' => 'required|string',
            'key_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            $worker =  Worker::where('worker_code', $request->worker_code)->first();;

            if (!$worker) {
                return $this->sendError('Invalid worker code. Please enter a valid Worker code', []);
            }

            $key =  Key::where(['id' => $request->key_id])->first();

            if (!$key) {
                return $this->sendError('Key not found', []);
            }

            if ($key->key_status) {
                return $this->sendError('Key has already been taken', []);
            }


            $keyInserted = KeyLog::create(['worker_id' => $worker->id, 'key_id' => $request->key_id, 'time_in' => Carbon::now()]);
            $key->key_status = 1;
            $key->save();

            return $this->sendResponse($keyInserted, 'Key Pick Logged successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function keyLogs(Request $request)
    {

        try {

            $workers = DB::table('key_logs')->join('workers', 'workers.id', '=', 'key_logs.worker_id')->join('keys', 'keys.id', '=', 'key_logs.key_id')->select('key_logs.*', 'workers.first_name', 'workers.image_url', 'workers.last_name', 'keys.key_name')->get();

            return $this->sendResponse($workers, 'Key Pick Logged successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function dropKey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_code' => 'required|string',
            'key_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            $key =  Key::find($request->key_id);

            if (!$key) {
                return $this->sendError('Key not found', []);
            }

            $worker =  Worker::where('worker_code', $request->worker_code)->first();;

            if (!$worker) {
                return $this->sendError('Invalid worker code. Please enter a valid Worker code', []);
            }


            if ($key->key_status == 0) {
                return $this->sendError('Key was never picked so it cannot dropped', []);
            }

            $keyInserted = KeyLog::where(['worker_id' => $worker->id, 'key_id' => $request->key_id])->first();

            if (!$keyInserted) {
                return $this->sendError('You cannot drop this key. Only the worker that picked the key can drop it', []);
            }

            $key->key_status = 0;
            $key->save();

            $keyInserted->time_out = Carbon::now();
            $keyInserted->save();

            return $this->sendResponse($keyInserted, 'Key Drop Logged successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
