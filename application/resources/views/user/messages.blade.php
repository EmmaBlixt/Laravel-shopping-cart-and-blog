@extends('layouts.master')

<script type='text/javascript'>
function asd(a)
{
    if(a==1)
    document.getElementById("asd").style.display="none";

    else
    document.getElementById("asd").style.display="block";

    var hide_button = document.getElementById('hide');
        if (hide_button.style.display === 'block' || hide_button.style.display === '')
            hide_button.style.display = 'none';
        else
          hide_button.style.display = 'block'
}
</script>

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


@section('title')
	Messages
@endsection

@section('content')
<h1>User messages</h1>


@include('includes.error-messages')

    <div class="centered">


      <!-- Displayes all recieved messages, if there are any -->
@if(!$recieved_messages->count())
    <h2>You have no messages</h2>
@else

    <h2>Unread messages:</h2>
     @foreach ($recieved_messages as $recieved_message)

     <div class="message-div">
        <a href="{{ route('profile', ['username' => $recieved_message->sender->name, 'id' => $recieved_message->sender->id]) }}">
            <img src="/uploads/avatars/{{ $recieved_message->sender->profile_img }}">
            <h3>From: {{ $recieved_message->sender->name . ' ' . $recieved_message->sender->last_name }}</h3>
        </a>
            <p class="msg">{{ $recieved_message->message }}</p>
        <p class="timestamp">Sent at {{ $recieved_message->updated_at }}</p>

<div id="asd">
        {!! Form::open(array('method'=>'POST', 'action' => 'MessageController@reply_to_message')) !!}
           <p>{!! Form::textarea('message', null, array('placeholder' => 'Reply to the message')); !!}</p>
           <p>{!! Form::submit('Send message', array('class' => 'button success')); !!}</p>
           {!! Form::hidden('message_id', $recieved_message->id) !!}
          {!! Form::close() !!}
        <button class="button" id="show" onclick="asd(1)">Cancel</button>
</div> <!-- end of #asd -->

<button class="button success" id="hide" onclick="asd(2)">Reply</button>

        <a href="{{ route('delete-message', ['id' => $recieved_message->id]) }}">
            <button class="button" onclick="ConfirmDelete()">Delete</button>
        </a>
     </div> <!-- end of .message-div -->

     @endforeach

@endif

<hr>

  <!-- Display messages that the user sent, if there are any -->
@if(!$sent_messages->count())
    <h2>You haven't sent any messages yet.</h2>
@else
     <h2>Sent messages:</h2>
     @foreach ($sent_messages as $sent_message)

    <div class="message-div">
        <a href="{{ route('profile', ['username' => $sent_message->user->name, 'id' => $sent_message->user->id]) }}">
            <img src="/uploads/avatars/{{ $sent_message->user->profile_img }}">
            <h3>To: {{ $sent_message->user->name . ' ' . $sent_message->user->last_name }}</h3>
        </a>
            <p class="msg">{{ $sent_message->message }}</p>
        <p class="timestamp">Sent at {{ $sent_message->updated_at }}</p>

    </div> <!-- end of .message-div -->
     @endforeach

@endif

</div> <!-- end of .centered -->
@endsection