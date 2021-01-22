@extends("layouts.global")
@section("title") Create Category @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Create Category</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif

    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('categories.store') }}" method="POST" autocomplete="off">
        @csrf
        <label for="name">Category Name</label>
        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}">
        @if ($errors->has('name'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('name') }}</div>
            </span>
        @endif
        <br>

        <label for="avatar">Category Image</label>
        <br>
        <input type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
        @if ($errors->has('image'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('image') }}</div>
            </span>
        @endif
        <br>
        
        <input type="submit" class="btn btn-primary" value="Save">
    </form>
</div>
@endsection
