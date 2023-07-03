<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //

    public function getTodayEvent(Request $request)
    {
        try {

            $event = Event::whereDate('start_time', '=', Carbon::now())->first();

            if (!$event) {
                return $this->sendError('No Event found for today', []);
            }

            return $this->sendResponse($event, 'Event fetched Successfully');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
