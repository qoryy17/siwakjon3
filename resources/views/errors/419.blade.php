@extends('errors.layouts.index-errors', ['title' => '419 Page Expired | ' . env('APP_NAME')])
@section('title', '419 Page Expired | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '419 Page Expired | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
