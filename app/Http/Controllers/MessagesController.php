<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            "title" => ["required", "string", "max:255"],
            "body" => ["required", "string"],
            "scheduled_opening_time" => ["date"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $message = request()->user()->messages()->create($validator->validate());

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = request()->user()->messages()->find($id);

        if (is_null($message) || !$message->canBeOpened()) {
            return response()->json(['message' => 'The message cannot be updated at this time.'], 403);
        }

        $message->is_opened = 1;
        $message->save();

        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $message = request()->user()->messages()->find($id);

        if (is_null($message) || !$message->canBeOpened()) {
            return response()->json(['message' => 'The message cannot be updated at this time.'], 403);
        }

        $validator = Validator::make(request()->all(), [
            "title" => ["required", "string", "max:255"],
            "body" => ["required", "string"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $message->update([
            "title" => $validator->validate()["title"],
            "body" => $validator->validate()["body"]
        ]);

        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return request()->user()->messages()->where('id', $id)->delete();
    }
}
