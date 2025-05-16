@extends('errors.layouts.index-errors', ['title' => '505 HTTP Version Not Supported | ' . env('APP_NAME')])
@section('title', '505 HTTP Version Not Supported | ' . env('APP_NAME'))
@section('content')
    @include('errors.layouts.content-errors', [
        'code' => $exception->getStatusCode(),
        'title' => '505 HTTP Version Not Supported | ' . env('APP_NAME'),
        'message' => $exception->getMessage(),
    ])
@endsection
