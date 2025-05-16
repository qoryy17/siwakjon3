@extends('errors.layouts.index-errors', ['title' => '404 Not Found | ' . env('APP_NAME')])
@section('title', '404 Not Found | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '404 Not Found | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
