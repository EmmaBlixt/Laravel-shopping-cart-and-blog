@extends('layouts.master')
@section('title')
    Edit event
@endsection

@section('content')
<h1>Edit event</h1>


@include('includes.error-messages')

<div class="centered">

                {!! Form::open(array('action' => 'CalendarController@edit_event')) !!}
                    <p>{!! Form::text('title', $event->title); !!}</p>
                    <p>{!! Form::textarea('info', $event->info); !!}</p>
                    <p>{!! Form::input('date', 'event_date', $event->event_date); !!}</p>
                    <p>{!! Form::input('time', 'time', $event->time); !!}</p>
                    <p>{!! Form::text('location', $event->location); !!}</p>
                        {!! Form::hidden('id', $event->id) !!}
                    <p>{!! Form::submit('Save changes', array('class' => 'button')); !!}</p>
                {!! Form::close() !!}
            
</div>
@endsection