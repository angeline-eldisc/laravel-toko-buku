@extends("layouts.global")
@section("title") Create Book @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Create Book</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif
    
    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('books.store') }}" method="POST" autocomplete="off">
        @csrf
        <label for="title">Title</label>
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Book Title" type="text" name="title" id="title" value="{{ old('title') }}">
        @if ($errors->has('title'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('title') }}</div>
            </span>
        @endif
        <br>

        <label for="cover">Cover</label>
        <br>
        <input id="cover" name="cover" type="file" class="form-control{{ $errors->has('cover') ? ' is-invalid' : '' }}">
        @if ($errors->has('cover'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('cover') }}</div>
            </span>
        @endif
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Give a description about this book">{{ old('description') }}</textarea>
        @if ($errors->has('description'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('description') }}</div>
            </span>
        @endif
        <br>

        <label for="categories">Categories</label>
        <br>
        <select name="categories[]" multiple="multiple" id="categories" class="form-control{{ $errors->has('categories') ? ' is-invalid' : '' }}">
            <option></option>
        </select><br>
        @if ($errors->has('categories'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('categories') }}</div>
            </span>
        @endif
        <br>

        <label for="stock">Stock</label>
        <input class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" placeholder="0">
        @if ($errors->has('stock'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('stock') }}</div>
            </span>
        @endif
        <br>

        <label for="author">Author</label>
        <input class="form-control{{ $errors->has('author') ? ' is-invalid' : '' }}" placeholder="Book Author" type="text" name="author" id="author" value="{{ old('author') }}">
        @if ($errors->has('author'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('author') }}</div>
            </span>
        @endif
        <br>
        
        <label for="publisher">Publisher</label>
        <input class="form-control{{ $errors->has('publisher') ? ' is-invalid' : '' }}" placeholder="Book Publisher" type="text" name="publisher" id="publisher" value="{{ old('publisher') }}">
        @if ($errors->has('publisher'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('publisher') }}</div>
            </span>
        @endif
        <br>

        <label for="price">Price</label>
        <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price') }}" placeholder="Book Price">
        @if ($errors->has('price'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('price') }}</div>
            </span>
        @endif
        <br>
        <button type="submit" class="btn btn-primary" name="save_action" value="PUBLISH">Publish</button>
        <button type="submit" class="btn btn-secondary" name="save_action" value="DRAFT">Save as draft</button>
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
    });
</script>
@endsection
