@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Back</a>
    <h1>{{$posts->title}}</h1>
    <img src="/storage/cover_images/{{$posts->cover_image}}" style="width: 100%"><br>
    <section>{!!$posts->body!!}</section>
    <hr>
    <small>Written on {{$posts->created_at}} By {{$posts->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $posts->user_id)
            <a href="/posts/{{$posts->id}}/edit" class="btn btn-default">Edit</a>

            {!! Form::open(['action'=>['App\Http\Controllers\PostsController@destroy', $posts->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
            {{Form::hidden('_method','Delete', ['class'=>'btn btn-danger'])}}
            {{Form::submit('Delete')}}
            {!! Form::close() !!}
        @endif
    @endif
@endsection
