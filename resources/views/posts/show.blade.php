@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Back</a>
    <h1>{{$posts->title}}</h1>
    <section>{{$posts->body}}</section>
    <hr>
    <small>Written on {{$posts->created_at}}</small>
@endsection
