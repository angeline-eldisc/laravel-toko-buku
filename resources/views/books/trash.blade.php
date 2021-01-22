@extends("layouts.global")
@section("title") Trashed Books @endsection
@section("content")
<div class="col-md-11" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Trashed Books</h2>
    <div class="row">
        <div class="col-md-6" style="padding-right: 0px; padding-left: 0px;">
            <form action="{{route('books.index')}}" autocomplete="off">
                <div class="input-group col-md-12 mb-2">
                    <input type="text" class="form-control" placeholder="Filter by title" value="{{Request::get('keyword')}}" name="keyword">
                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="btn btn-primary"> 
                    </div>
                </div>
            </form>
        </div>
            
        <div class="col-md-6 mb-3 pl-4">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link {{ Request::get('status') == NULL && Request::path() == 'books' ? 'active' : '' }}" href="{{ route('books.index') }}">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::get('status') ==  'publish'  ? 'active' : '' }}" href="{{ route('books.index', ['status' => 'publish']) }}">Publish</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::get('status') ==  'draft'  ? 'active' : '' }}" href="{{ route('books.index', ['status' => 'draft']) }}">Draft</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::path() == 'books/trash' ? 'active' : ''}}" href="{{ route('books.trash') }}">Trash</a>
                </li>
            </ul>
        </div>
    </div>

    <hr style="margin: 2% 0px;">
    <div class="row">
        <div class="col">
            <a class="btn btn-primary text-white btn-sm mb-3 mt-1 float-left" href="{{route('books.create')}}">Create User</a>
        </div>
        <div class="col">
            <a class="btn btn-warning text-white btn-sm mb-3 mt-1 float-right" href="{{route('books.index')}}">Refresh</a>
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
                    <th><b>Cover</b></th>
                    <th><b>Title</b></th>
                    <th><b>Author</b></th>
                    <th><b>Status</b></th>
                    <th><b>Categories</b></th>
                    <th><b>Stock</b></th>
                    <th><b>Price</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @if($books->count() > 0)
                    @foreach($books as $book)
                        <tr>
                            <td class="text-center">
                                @if($book->cover)
                                    <img src="{{ asset('images/book-covers/'.$book->cover) }}" alt="cover" width="76">
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>
                                @if($book->status == "DRAFT")
                                    <span class="badge bg-dark text-white">{{ $book->status }}</span>
                                @else
                                    <span class="badge bg-success text-white">{{ $book->status }}</span>
                                @endif
                            </td>
                            <td>
                                <ul class="pl-3">
                                    @foreach($book->categories as $category)
                                        <li>{{ $category->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $book->stock }}</td>
                            <td>{{ $book->price }}</td>
                            <td>
                                <a class="btn btn-success text-white btn-sm mb-2"  href="{{route('books.restore', $book->id)}}">Restore</a>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#deletePermanentbookModal">
                                    Delete
                                </button>
                                
                                <form id="deletePermanent-book-modal" action="{{ route('books.delete-permanent', $book->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center">No record found.</td>
                </tr>
                @endif
                <tfoot>
                    <tr class="pt-2">
                        <td colspan="10">
                            {{$books->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>

<div class="modal faster animated zoomIn" id="deletePermanentbookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <p>Do you want to permanently delete this book?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                <button type="buttom" class="btn btn-danger btn-lg" onclick="event.preventDefault(); document.getElementById('deletePermanent-book-modal').submit();">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection