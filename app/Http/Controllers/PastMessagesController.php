<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use Carbon\Carbon;

class PastMessagesController extends Controller
{
    public function __invoke()
    {
        $messages = request()->user()->messages()->where('scheduled_opening_time', '<=', Carbon::now())->get();

        return MessageResource::collection($messages);
    }
}
