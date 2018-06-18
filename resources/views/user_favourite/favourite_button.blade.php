@if (Auth::id() != $user->id)
    @if (Auth::user()->is_favouriting($user->favourite_id))
        {!! Form::open(['route' => ['user.unfavouritew', $user->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unpin', ['class' => "btn btn-danger btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.favouriting', $user->id]]) !!}
            {!! Form::submit('Favourite', ['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif
@endif