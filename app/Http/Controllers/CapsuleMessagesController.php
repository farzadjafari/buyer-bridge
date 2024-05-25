<?php

namespace App\Http\Controllers;

use App\Http\Resources\CapsuleMessageResource;
use Carbon\Carbon;

class CapsuleMessagesController extends Controller
{
    public function __invoke()
    {
        $messages = request()->user()->messages()->where('scheduled_opening_time', '>', Carbon::now())->get();

        return CapsuleMessageResource::collection($messages);
    }
}
