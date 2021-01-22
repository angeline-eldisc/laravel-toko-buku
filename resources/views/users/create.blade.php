@extends("layouts.global")
@section("title") Create New User @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Create New User</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif
    
    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.store') }}" method="POST" autocomplete="off">
        @csrf
        <label for="name">Name</label>
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Full Name" type="text" name="name" id="name" value="{{ old('name') }}">
        @if ($errors->has('name'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('name') }}</div>
            </span>
        @endif
        <br>

        <label for="username">Username</label>
        <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" type="text" name="username" id="username" value="{{ old('username') }}">
        @if ($errors->has('username'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('username') }}</div>
            </span>
        @endif
        <br>
        
        <label for="roles">Roles</label>
        <br>
        <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN" {{ is_array(old('roles')) && in_array("ADMIN", old('roles')) ? "checked" : "" }}>
        <label for="ADMIN">Administrator</label>
        <input type="checkbox" name="roles[]" id="STAFF" value="STAFF" {{ is_array(old('roles')) && in_array("STAFF", old('roles')) ? "checked" : "" }}>
        <label for="STAFF">Staff</label>
        <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER" {{ is_array(old('roles')) && in_array("CUSTOMER", old('roles')) ? "checked" : "" }}>
        <label for="CUSTOMER">Customer</label>
        <br>
        @if ($errors->has('roles'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('roles') }}</div>
            </span>
        @endif

        <br>
        <label for="phone">Phone number</label>
        <br>
        <input type="text" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}">
        @if ($errors->has('phone'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('phone') }}</div>
            </span>
        @endif
        <br>

        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{ old('address') }}</textarea>
        @if ($errors->has('address'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('address') }}</div>
            </span>
        @endif
        <br>

        <label for="avatar">Avatar Image</label>
        <br>
        <input id="avatar" name="avatar" type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}">
        @if ($errors->has('avatar'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('avatar') }}</div>
            </span>
        @endif
        <hr class="my-4" style="height: 1.5px; border-width: 0; color: gray; background-color: gray">

        <label for="email">Email</label>
        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="user@mail.com" type="text" name="email" id="email" value="{{ old('email') }}">
        @if ($errors->has('email'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('email') }}</div>
            </span>
        @endif
        <br>

        <label for="password">Password</label>
        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" type="password" name="password" id="password" autocomplete="new-password">
        @if ($errors->has('password'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('password') }}</div>
            </span>
        @endif
        <br>

        <label for="password_confirmation">Password Confirmation</label>
        <input class="form-control" placeholder="Password confirmation" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
        <br>
        
        <input class="btn btn-primary" type="submit" value="Save">
    </form>
</div>
@endsection
