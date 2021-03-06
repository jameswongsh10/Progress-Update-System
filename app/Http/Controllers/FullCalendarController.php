<?php

namespace App\Http\Controllers;

use Acaronlex\LaravelCalendar\Facades\Calendar;
use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Http\Request;


class FullCalendarController extends Controller
{
    public function usercalendar(Request $request, $id) {
//        if($request->ajax()) {
//            $data = CalendarEvent::whereDate('start_date', '>=', $request->start)
//                ->whereDate('end_date', '<=', $request->end)
//                ->get(['id', 'title', 'start_date', 'end_date']);
//            return response()->json($data);
//        }
//        return view('admincalendar');
        $scheduleEvents= [];
        $user = User::find($id);
        $data = CalendarEvent::all();
        if($data->count()) {
            foreach($data as $key => $value) {
                if($value->user_id == $user->id) {
                    $scheduleEvents[] = Calendar::event(
                        $value->title,
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date),
                    );
                }
            }
        }
        $calendar = Calendar::addEvents($scheduleEvents);
        return view('calendar', compact('calendar', 'user'));
    }
}
