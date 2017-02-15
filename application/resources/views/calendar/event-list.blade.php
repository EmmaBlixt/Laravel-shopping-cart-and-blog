@extends('layouts.master')
@section('title')
    List of events
@endsection

@section('content')
<h1>Upcoming events</h1>


@include('includes.error-messages')

<div class="centered">

             <div id="listed-events">
					@foreach($events as $event)
             			<div id="event" class="event-rows">
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
			</div> <!--  end of #listed-events -->
		<a href="{{ route('calendar') }}"><h2>← Back to calendar</h2></a>
</div>
@endsection



