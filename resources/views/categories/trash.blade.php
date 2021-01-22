@extends("layouts.global")
@section("title") Trashed Categories @endsection
@section("content")
<div class="col-md-11" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Trashed Categories</h2>
    <form action="{{route('categories.index')}}" autocomplete="off">
        <div class="row">
            <div class="col-md-6" style="padding-right: 0px;">
                <div class="input-group mb-3">
                    <input value="{{Request::get('name')}}" name="name" class="form-control col-md-12" type="text" placeholder="Filter category by name">
                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="btn btn-primary">
                    </div>
                </div>
            </div>
            
            <div  class="col-md-6">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a class="nav-link ml-3" href="{{route('categories.index')}}">Published</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('categories.trash')}}">Trash</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr style="margin: 2% 0px;">
        <div class="row">
            <div class="col">
                <a class="btn btn-primary text-white btn-sm mb-3 mt-1 float-left" href="{{route('categories.create')}}">Create User</a>
            </div>
            <div class="col">
                <a class="btn btn-warning text-white btn-sm mb-3 mt-1 float-right" href="{{route('categories.index')}}">Refresh</a>
            </div>
        </div>
    </form>
        
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
                                <a class="btn btn-success text-white btn-sm mb-2"  href="{{route('categories.restore', $category->id)}}">Restore</a>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#deletePermanentCategoryModal">
                                    Delete
                                </button>
                                
                                <form id="deletePermanent-category-modal" action="{{ route('categories.delete-permanent', $category->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    {{ method_field('DELETE') }}
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

<div class="modal faster animated zoomIn" id="deletePermanentCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" style="background-color:transparent; border: 1px solid transparent; font-size: 24px; margin-top: -2%;">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center" style="color: orange; font-size: 100px; margin-top: -4%;">
                    <i class="fas fa-exclamation"></i>
                </div>
                <div class="text-center" style="font-size: 32px; margin-top: -3%;">
                    <b>Are you sure?</b>
                </div>
                <div class="text-center" style="font-size: 18px;">
                    <p>Do you want to permanently delete this category?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                <button type="buttom" class="btn btn-danger btn-lg" onclick="event.preventDefault(); document.getElementById('deletePermanent-category-modal').submit();">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection