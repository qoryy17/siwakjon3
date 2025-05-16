@extends('errors.layouts.index-errors', ['title' => '429 Too Many Requests | ' . env('APP_NAME')])
@section('title', '429 Too Many Requests | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '429 Too Many Requests | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
