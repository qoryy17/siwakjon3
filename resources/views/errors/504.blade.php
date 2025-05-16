@extends('errors.layouts.index-errors', ['title' => '504 Gateway Timeout | ' . env('APP_NAME')])
@section('title', '504 Gateway Timeout | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '504 Gateway Timeout | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
