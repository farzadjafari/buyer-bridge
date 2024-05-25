<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;

class MessagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = request()->validate([
            "title" => ["required", "string", "max:255"],
            "body" => ["required", "string"],
            "scheduled_opening_time" => ["date"]
        ]);

        $message = request()->user()->messages()->create($data);

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

        request()->validate([
            "title" => ["required", "string", "max:255"],
            "body" => ["required", "string"]
        ]);

        $message->update([
            "title" => request('title'),
            "body" => request('body')
        ]);

        return new MessageResource($message);
    }
}
