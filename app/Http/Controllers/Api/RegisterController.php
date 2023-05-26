<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Key;
use App\Models\KeyLog;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            $workersCount = Worker::all()->count();
            $keysCount = Key::all()->count();
            $keyLogsCount = KeyLog::all()->count();

            $success['dashboard_count']['workers_count'] = $workersCount;
            $success['dashboard_count']['keys_count'] = $keysCount;
            $success['dashboard_count']['key_logs_count'] = $keyLogsCount;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Invalid login credentials', ['error' => 'Unauthorised']);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }
}
