@extends('errors.layouts.index-errors', ['title' => '502 Bad Gateway | ' . env('APP_NAME')])
@section('title', '502 Bad Gateway | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '502 Bad Gateway | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
