<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">--}}
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <title>Laravel fullstack</title>
    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{csrf_token()}}'
            };
        })();
    </script>
</head>
<body>
<div id="app">
    @if(\Illuminate\Support\Facades\Auth::check())
        <my-first :user="{{\Illuminate\Support\Facades\Auth::user()}}"></my-first>
    @else
        <my-first :user="false"></my-first>
    @endif
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
