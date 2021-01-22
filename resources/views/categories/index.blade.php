@extends("layouts.global")
@section("title") Categories List @endsection
@section("content")
<div class="col-md-11" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Categories List</h2>
    <div class="row">
        <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
            <form action="{{route('categories.index')}}" autocomplete="off">
                <div class="input-group col-md-12 mb-2">
                    <input type="text" class="form-control" placeholder="Filter by category name" value="{{Request::get('name')}}" name="name">
                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="btn btn-primary"> 
                    </div>
                </div>
            </form>
        </div>
            
        <div class="col-md-6 mb-3 pl-4">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('categories.index') }}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.trash') }}">Trash</a>
                </li>
            </ul>
        </div>
    </div>
    <hr style="margin: 1% 0px;">
    <div class="row">
        <div class="col">
            <a class="btn btn-primary text-white btn-sm mb-3 mt-1 float-left" href="{{route('categories.create')}}">Create Category</a>
        </div>
        <div class="col">
            <a class="btn btn-warning text-white btn-sm mb-3 mt-1 float-right" href="{{route('categories.index')}}">Refresh</a>
        </div>
    </div>
        
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif

    @if(session()->has('warning'))
        <div class="alert alert-warning alert-message" role="alert">
            {{ session()->get('warning') }}
        </div>
    @endif
    <div style="overflow-x:auto;">
        <table class="table table-bordered table-stripped table-hover">
            <thead>
                <tr>
                    <th><b>Name</b></th>
                    <th><b>Slug</b></th>
                    <th><b>Image</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @if($categories->count() > 0)
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="text-center">
                                @if($category->image)
                                    <img src="{{ asset('images/categories/'.$category->image) }}" alt="image" width="76">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-info text-white btn-sm mb-2 float-left mr-1" href="{{route('categories.edit', $category->id)}}">Edit</a>
                                <a class="btn btn-primary text-white btn-sm mb-2 float-left mr-1" href="{{route('categories.show', $category->id)}}">Detail</a>
                                <form class="d-inline float-left" action="{{route('categories.destroy', $category->id)}}" method="POST" onsubmit="return confirm('Move category to trash?')">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" class="btn btn-danger btn-sm" value="Trash">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">No record found.</td>
                </tr>
                @endif
                <tfoot>
                    <tr class="pt-2">
                        <td colspan="10">
                            {{$categories->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>
@endsection
