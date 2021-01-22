@extends("layouts.global")
@section("title") Edit Category @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Edit Category</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif

    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('categories.update', $category->id) }}" method="POST" autocomplete="off">
        @csrf
        {{ method_field('PUT') }}
        <label for="name">Category Name</label>
        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $category->name }}">
        @if ($errors->has('name'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('name') }}</div>
            </span>
        @endif
        <br>

        <label for="slug">Category Slug</label>
        <input type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug') ? old('slug') : $category->slug }}">
        @if ($errors->has('slug'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('slug') }}</div>
            </span>
        @endif
        <br>

        <label for="image">Category Image</label>
        @if($category->image)
            <br>
            <img src="{{asset('images/categories/'.$category->image)}}" width="120px" class="mb-2">
        @endif
        <br>
        <input type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
        @if ($errors->has('image'))
            <span class="help-block float-left">
                <div style="font-size: 13px; color: red;">{{ $errors->first('image') }}</div>
            </span>
        @endif
        <small class="text-muted float-right">Kosongkan jika tidak ingin mengubah gambar</small>
        <br>

        <div class="my-3"></div>
        
        <input type="submit" class="btn btn-primary" value="Update">
    </form>
</div>
@endsection
