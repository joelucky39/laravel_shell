<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <title>{{config('app.name', 'Laravel CMS')}}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="antialiased">
@include('inc.navbar')
<div class="container">
    @include('inc.messages')
    @yield('content')
</div>

<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'article-ckeditor' );
</script>
</body>
</html>
