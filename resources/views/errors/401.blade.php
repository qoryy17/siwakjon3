@extends('errors.layouts.index-errors', ['title' => '401 Unauthorized | ' . env('APP_NAME')])
@section('title', '401 Unauthorized | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '401 Unauthorized | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
