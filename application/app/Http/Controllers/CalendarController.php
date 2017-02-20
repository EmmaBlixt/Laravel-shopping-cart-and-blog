<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use App\Calendar;
use App\Event;
use URL;
use App\User;
use Auth;

class CalendarController extends Controller
{

public function get_calendar() {
        $calendar = new Calendar(date('D M Y'));

        // fetch the first event that is the closest to today's date
        $first_event = Event::where('user_id', Auth::user()->id)
                  ->where('event_date', '>=', date('Y-m-d'))
                  ->orderBy('event_date', 'ASC')
                  ->first();

           // delete old events that have passed and were made two months ago
        $old_event = Event::where('event_date', '<', date('Y-m-d'))
                      ->where('created_at', '<', date("Y-m-d",strtotime("-2 Months")))
                      ->delete();

          if( $first_event == null) {
              return view('calendar.calendar', ['calendar' => $calendar->show(),
                'events' => $first_event]);
          }


            else {
            // fetch all events that take place on the same date as the next upcoming one
              $events = Event::where('event_date', '=', $first_event->event_date)
                  ->where('user_id', Auth::user()->id)
                  ->orderBy('event_date', 'ASC','time', 'DESC')
                  ->get();
                  return view('calendar.calendar', ['calendar' => $calendar->show(),
                        'events' => $events]);
    }
  
 }

/*
|--------------------------------------------------------------------------
| Add event
|--------------------------------------------------------------------------
|
| Allows users to add upcoming events to their calendar
|
*/

public function add_event(){
    return view('calendar.add-event');
}


public function post_add_event(Request $request) {

       $this->validate($request, [
      'title' => 'required|max:200',
      'info' => 'required|max:1000',
      'event_date' => 'required',
      'location' => 'max:200'
      ]);

          $new_event = new Event([
            'title' => $request['title'],
            'info' => $request['info'],
            'time' => $request['time'], 
            'event_date' => $request['event_date'], 
            'location' => $request['location'],
            'user_id' => Auth::user()->id
            ]); 

            $message = "An error occured";
     // if event is successfully uploaded, print event & redirect
     if($new_event->save()){
      $message = "Event saved! (:";
     }
    return redirect()->route('calendar')->with((['message' => $message]));
  }



/*
|--------------------------------------------------------------------------
| Edit events
|--------------------------------------------------------------------------
|
| Allows users to edit their events
|
*/

public function get_edit_event($id){
    $event = Event::find($id);
    return view('calendar.edit-event',['event' => $event]);
}


public function edit_event(Request $request) {
      $id = $request->input('id');
     $event = Event::find($id);

    $this->validate($request, [
      'title' => 'max:200',
      'info' => 'max:1000',
      'location' => 'max:200',
      'event_date' => 'required'
      ]);


          $event->title = $request->input('title');
          $event->info = $request->input('info');
          $event->time = $request->input('time');
          $event->event_date = $request->input('event_date');
          $event->location = $request->input('location');
          $event->user_id = Auth::user()->id;


      // sending back with message
          $message = "An error occured";
     // if event is successfully updated, print event & redirect
     if($event->save()){
      $message = "Event updated! (:";
     }
    return redirect()->route('calendar')->with((['message' => $message]));
  }


/*
|--------------------------------------------------------------------------
| Delete event
|--------------------------------------------------------------------------
|
| Lets users delete events, also removes ones that are a month old
|
*/

public function delete_event($id) {

    $event = Event::find($id);
    Event::where('id', $id)->delete();
    $message = "Event deleted.";

    return redirect()->route('calendar')->with((['message' => $message]));
}


/*
|--------------------------------------------------------------------------
| Get event list
|--------------------------------------------------------------------------
|
| Get the list of all upcoming events for this user
|
*/
public function get_event_list(){
        $events = Event::where('event_date', '>=', date('Y-m-d'))
                  ->where('user_id', Auth::user()->id)
                  ->orderBy('event_date', 'ASC', 'time', 'DESC')
                  ->get();

        return view('calendar.event-list', ['events' => $events]);
}



}