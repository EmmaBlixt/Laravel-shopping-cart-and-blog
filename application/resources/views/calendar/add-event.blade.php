@extends('layouts.master')
@section('title')
    Add event
@endsection

@section('content')
<h1>Add an event</h1>


@include('includes.error-messages')

<div class="centered">

           {!! Form::open(array('method'=>'POST', 'action' => 'CalendarController@post_add_event')) !!}
            <p>{!! Form::text('title', null, array('placeholder' => 'Event title')); !!}</p>
           <p>{!! Form::textarea('info', null, array('placeholder' => 'Describe your event')); !!}</p>
           <p>{!! Form::input('date', 'event_date', null); !!}</p>
           <p>{!! Form::input('time', 'time', null); !!}</p>
           <p>{!! Form::text('location', null, array('placeholder' => 'Location')); !!}</p>
           <h3>{!! Form::submit('Save event', array('class' => 'button')); !!}</h3>
          {!! Form::close() !!}
            
</div>
@endsection



