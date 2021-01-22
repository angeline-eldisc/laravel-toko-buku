@extends('layouts.app')
@section("title") Error 404 Not Found @endsection
@section('content')
<div class="d-flex flex-row justify-content-center vertical-center">
    <div class="col-md-6 text-center">
        <div class="alert alert-danger">
            <h1>404</h1>
            {{-- <h4>{{$exception->getMessage()}}</h4> --}}
            <h4>Halaman yang Anda akses tidak ditemukan</h4>
        </div>
    </div>
</div>
@endsection