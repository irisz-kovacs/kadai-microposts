    @if (Auth::user()->is_favouriting($micropost->id))
        {!! Form::open(['route' => ['user.unfavourite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Remove', ['class' => "btn btn-success btn-xs"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.favouriting', $micropost->id]]) !!}
            {!! Form::submit('Favourite', ['class' => "btn btn-danger btn-xs"]) !!}
        {!! Form::close() !!}
    @endif
