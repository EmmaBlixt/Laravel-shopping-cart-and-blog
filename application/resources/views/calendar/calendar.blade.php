@extends('layouts.master')

@section('title')
	Calendar
@endsection

@section('content')

@include('includes.error-messages')

<script type='text/javascript'>
function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}
</script>


<div class="event-handler">
  <a href="{{ route('event-list') }}">See all events</a>
  <a href="{{ route('add-event') }}"><button class="button">Add event</button></a>
</div> <!--  end of .event-handler -->

   	
				<!-- Check if user have upcoming events & loop through them   -->
            @if (!$events)
              <div id="no-event">
                  <p>You have no upcoming events</p>
                  <button class="button" id="hide" onclick="add_event(2)">Add event</button>
              </div> <!--  end of #no-event -->
             @else   

                <div id="event-group">
                  <h3>Upcoming events</h3>
                      <!-- print out all of the events for this day -->
                    @foreach ($events as $event)
                      <div id="event">
                          <h3>{{ $event->title }}</h3>
                            <p>{{ $event->info }}</p>
                            <p class="event-info">{{ $event->location }}
                              @if ($event->location)
                              ,  <!-- if the location of the event is set add separating , -->
                              @endif
                              {{ substr($event->time,-8,5) }}
                            </p> <!--  end of .event-info -->
                            <p class="event-info"> {{ $event->event_date }} </p>
                            <a href="{{ route('edit-event', ['id' => $event->id]) }}" class="edit" title="Edit event"></a>
                            <a href="{{ route('delete-event', ['id' => $event->id]) }}" onclick="ConfirmDelete()" class="delete" title="Delete event"></a>
                      </div> <!--  end of #event -->
                @endforeach
                  </div> <!--  end of #event-group -->
            @endif

<div class="container-fluid">
 <div class="media_box">
  <div class="row media_box">
   <div class="col-md-6">       
    <?=$calendar?>
   </div> <!--  end of .col-md-6 -->
  </div> <!--  end of .row media_box -->
 </div> <!--  end of .media_box -->
</div> <!--  end of .container-fluid -->


<!-- hide/show event information on hover -->
<script type="text/javascript">
document.getElementById('event-group').style.visibility="hidden";

document.getElementById('event_today').onmouseover = function(){
    document.getElementById('event-group').style.visibility="visible";
} 
document.getElementById('event-group').onmouseout = function(){
        setTimeout(function () {
    document.getElementById('event-group').style.visibility="hidden";
  }, 2000);
}
</script>

@endsection