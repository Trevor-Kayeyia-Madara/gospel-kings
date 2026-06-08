<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Str;

class RegistrationNumberService
{
    public function generate(Event $event): string
    {
        $prefix = Str::upper((string) Str::of($event->slug)->replace('-', '')->substr(0, 6));
        $next = Registration::where('event_id', $event->id)->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, now()->format('y'), $next);
    }

    public function ticketNumber(Event $event): string
    {
        return sprintf('TKT-%s-%s', $event->id, Str::upper(Str::random(8)));
    }
}
