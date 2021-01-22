@extends("layouts.global")
@section("title") Books List @endsection
@section("content")
<div class="col-md-11" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Books List</h2>
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
    
    <hr style="margin: 1% 0px;">
    <div class="row">
        <div class="col">
            <a class="btn btn-primary text-white btn-sm mb-3 mt-1 float-left" href="{{route('books.create')}}">Create Book</a>
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
        <table class="table table-bordered table-hover">
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
                                <a class="btn btn-info text-white btn-sm mb-2 float-left mr-1" href="{{route('books.edit', $book->id)}}">Edit</a>
                                <a class="btn btn-primary text-white btn-sm mb-2 float-left mr-1" href="{{route('books.show', $book->id)}}">Detail</a>
                                <form class="d-inline float-left" action="{{route('books.destroy', $book->id)}}" method="POST" onsubmit="return confirm('Move book to trash?')">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" class="btn btn-danger btn-sm" value="Trash">
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
@endsection
