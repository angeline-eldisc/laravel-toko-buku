@extends("layouts.global")
@section("title") Detail Category @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Detail Category</h2>
    <div class="card">
        <div class="card-body">
            <label for="name"><b>Catgory Name</b></label><br>
            {{ $category->name }}
            <br><br>

            <label for="slug"><b>Catgory Slug</b></label><br>
            {{ $category->slug }}
            <br><br>

            <label for="image"><b>Catgory Image</b></label><br>
            @if($category->image)
                <img src="{{ asset('images/categories/'.$category->image) }}" alt="image" width="128">
            @endif
            <br><br>
        </div>
    </div>
</div>
@endsection
