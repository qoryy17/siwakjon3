@extends('errors.layouts.index-errors', ['title' => '503 Service Unavailable | ' . env('APP_NAME')])
@section('title', '503 Service Unavailable | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '503 Service Unavailable | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
