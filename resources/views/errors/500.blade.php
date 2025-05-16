@extends('errors.layouts.index-errors', ['title' => '500 Internal Server Error | ' . env('APP_NAME')])
@section('title', '500 Internal Server Error | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '500 Internal Server Error | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
