@extends('errors.layouts.index-errors', ['title' => '403 Forbidden | ' . env('APP_NAME')])
@section('title', '403 Forbidden | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '403 Forbidden | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
