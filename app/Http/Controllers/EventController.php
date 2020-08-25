<?php


namespace App\Http\Controllers;


use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::limit(4)->get();
        return view('event')->with([
            'events' => $events
        ]);
    }

    public function show(Request $request, Event $event)
    {
        dd($request->all(), $event);
    }
}
