<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Key;
use App\Models\KeyLog;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();

        $workersCount = Worker::all()->count();
        $keysCount = Key::all()->count();
        $keyLogsCount = KeyLog::all()->count();

        $success['dashboard_count']['workers_count'] = $workersCount;
        $success['dashboard_count']['keys_count'] = $keysCount;
        $success['dashboard_count']['key_logs_count'] = $keyLogsCount;


        return $this->sendResponse($success, 'Dashboard Items gotten successfully.');
    }
}
