@extends("layouts.global")
@section("title") Edit Book @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Edit Book</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif
    
    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{route('books.update', $book->id)}}" method="POST" autocomplete="off">
        @csrf
        {{ method_field('PUT') }}
        <label for="title">Title</label>
        <input value="{{$book->title}}" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Book Title" type="text" name="title" id="title">
        @if ($errors->has('title'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('title') }}</div>
            </span>
        @endif
        <br>

        <label for="cover">Current</label>
        <small class="text-muted">Current Cover</small><br>
        @if($book->cover)
            <img src="{{asset('images/book-covers/'.$book->cover)}}" width="96px" class="mb-2">
        @endif
        <br>
        <input id="cover" name="cover" type="file" class="form-control{{ $errors->has('cover') ? ' is-invalid' : '' }}">
        @if ($errors->has('cover'))
            <span class="help-block float-left">
                <div style="font-size: 13px; color: red;">{{ $errors->first('cover') }}</div>
            </span>
        @endif
        <small class="text-muted float-right">Kosongkan jika tidak ingin mengubah cover</small><br>

        <label for="slug">Slug</label>
        <input value="{{$book->slug}}" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="Enter a slug" type="text" name="slug" id="slug">
        @if ($errors->has('slug'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('slug') }}</div>
            </span>
        @endif
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{$book->description}}</textarea>
        @if ($errors->has('description'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('description') }}</div>
            </span>
        @endif
        <br>

        <label for="categories">Categories</label>
        <br>
        <select name="categories[]" multiple="multiple" id="categories" class="form-control{{ $errors->has('categories') ? ' is-invalid' : '' }} categories">
            <option></option>
        </select><br>
        @if ($errors->has('categories'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('categories') }}</div>
            </span>
        @endif
        <br>

        <label for="stock">Stock</label><br>
        <input value="{{$book->stock}}" type="number" name="stock" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" placeholder="Stock">
        @if ($errors->has('stock'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('stock') }}</div>
            </span>
        @endif
        <br>

        <label for="author">Author</label><br>
        <input value="{{$book->author}}" type="text" name="author" class="form-control{{ $errors->has('author') ? ' is-invalid' : '' }}" placeholder="Author">
        @if ($errors->has('author'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('author') }}</div>
            </span>
        @endif
        <br>

        <label for="publisher">Publisher</label><br>
        <input value="{{$book->publisher}}" type="text" name="publisher" class="form-control{{ $errors->has('publisher') ? ' is-invalid' : '' }}" placeholder="Publisher">
        @if ($errors->has('publisher'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('publisher') }}</div>
            </span>
        @endif
        <br>

        <label for="price">Price</label><br>
        <input value="{{$book->price}}" type="number" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="Price">
        @if ($errors->has('price'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('price') }}</div>
            </span>
        @endif
        <br>

        <label for="status">Status</label>
        <br>
        <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
            <option {{ $book->status == 'PUBLISH' ? 'selected' : '' }} value="PUBLISH">PUBLISH</option>
            <option {{ $book->status == 'DRAFT' ? 'selected' : '' }} value="DRAFT">DRAFT</option>                
        </select><br>
        @if ($errors->has('status'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('status') }}</div>
            </span>
        @endif
        <br>

        <input class="btn btn-primary" type="submit" value="Save">
    </form>
</div>
@endsection

@section('footer-scripts')
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#categories').select2({
            placeholder: 'Select Category',
            ajax: {
                url: 'http://localhost:8000/ajax/categories/search',
                processResults: function(data){
                    return  {
                        results: data.map(function(item){
                            return {id: item.id, text: item.name}
                        })
                    }
                }
            }
        });

        var categories = {!! $book->categories !!}
        categories.forEach(function(category){
        var option =  new  Option(category.name, category.id, true,  true);
            $('#categories').append(option).trigger('change');
        });
    });
</script>
@endsection
