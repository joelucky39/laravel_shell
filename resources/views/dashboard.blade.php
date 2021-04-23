@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Welcome {{$username}}</h3>
                    {{ __('You are logged in!') }}
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="card">
                <div class="card-header">Posts Admin</div>

                <div class="card-body">
                    <a href="/posts/create">{{ __('Create Posts') }}</a>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="card">
                <div class="card-header">{{ __('Blog Posts of') }} {{$username}}</div>
                <div class="card-body">
                    @if(count($posts)>0)
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td><a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a></td>
                                <td>
                                    {!! Form::open(['action'=>['App\Http\Controllers\PostsController@destroy', $post->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                                    {{Form::hidden('_method','Delete', ['class'=>'btn btn-danger'])}}
                                    {{Form::submit('Delete')}}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @else
                    <p>You have no posts</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
