<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Key;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeyController extends BaseController
{
    //


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key_name' => 'required|unique:keys'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            $keyInserted = Key::create(['key_name' => $request->key_name]);


            return $this->sendResponse($keyInserted, 'Key Added successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function allKeys(Request $request)
    {

        $keyInserted = Key::all();

        return $this->sendResponse($keyInserted, 'Key Added successfully.');
    }

    public function update(Request $request, $keyId)
    {

        $keyInserted = Key::find($keyId);

        if (!$keyInserted)
            return $this->sendError('Key Not found', []);

        $keyInserted->key_name = $request->key_name;
        $keyInserted->save();

        return $this->sendResponse($keyInserted, 'Key Updated successfully.');
    }


    public function delete($keyId)
    {

        $key = Key::find($keyId);

        if (!$key) return $this->sendError('Key Id does not exist', []);

        $key->delete();


        return $this->sendResponse([], 'Key Deleted successfully');
    }
}
