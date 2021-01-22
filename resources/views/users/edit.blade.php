@extends("layouts.global")
@section("title") Edit User @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Edit User</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif
    
    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.update', $user->id) }}" method="POST" autocomplete="off">
        @csrf
        {{ method_field('PUT') }}
        <label for="name">Name</label>
        <input value="{{ old('name') ? old('name') : $user->name }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Full Name" type="text" name="name" id="name">
        @if ($errors->has('name'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('name') }}</div>
            </span>
        @endif
        <br>

        <label for="username">Username</label>
        <input value="{{$user->username}}" disabled class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" type="text" name="username" id="username">
        @if ($errors->has('username'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('username') }}</div>
            </span>
        @endif
        <br>

        <label for="status">Status</label><br>
        <input {{$user->status  ==  "ACTIVE"  ? "checked" : ""}} value="ACTIVE" type="radio" class="form-control" id="active" name="status"><label for="active">Active</label>
        <input  {{$user->status  ==  "INACTIVE"  ? "checked" : ""}} value="INACTIVE" type="radio" class="form-control" id="inactive" name="status"><label for="inactive">Inactive</label>
        <br>

        <br>
        <label for="">Roles</label><br>
        <input type="checkbox" {{ in_array('ADMIN',  json_decode($user->roles)) ? 'checked' : '' }} name="roles[]" id="ADMIN" value="ADMIN"><label for="ADMIN">Administrator</label>
        <input type="checkbox" {{ in_array('STAFF',  json_decode($user->roles)) ? 'checked' : '' }} name="roles[]" id="STAFF" value="STAFF"><label for="STAFF">Staff</label>
        <input type="checkbox" {{ in_array('CUSTOMER', json_decode($user->roles)) ? 'checked' : '' }} name="roles[]" id="CUSTOMER" value="CUSTOMER"><label for="CUSTOMER">Customer</label>
        @if ($errors->has('roles'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('roles') }}</div>
            </span>
        @endif
        <br>

        <br>
        <label for="phone">Phone number</label><br>
        <input value="{{ old('phone') ? old('phone') : $user->phone }}" type="text" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">
        @if ($errors->has('phone'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('phone') }}</div>
            </span>
        @endif
        <br>

        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{ old('address') ? old('address') : $user->address }}</textarea>
        @if ($errors->has('address'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('address') }}</div>
            </span>
        @endif
        <br>

        <label for="avatar">Current Avatar</label>
        @if($user->avatar)
            <br>
            <img src="{{asset('images/avatars/'.$user->avatar)}}" width="120px" class="mb-2">
        @else
            (No avatar)
        @endif
        <br>
        <input id="avatar" name="avatar" type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}">
        @if ($errors->has('avatar'))
            <span class="help-block float-left">
                <div style="font-size: 13px; color: red;">{{ $errors->first('avatar') }}</div>
            </span>
        @endif
        <small class="text-muted float-right">Kosongkan jika tidak ingin mengubah avatar</small><br>

        <hr class="my-3">

        <label for="email">Email</label>
        <input value="{{$user->email}}" disabled class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="user@mail.com" type="text" name="email" id="email">
        @if ($errors->has('email'))
            <span class="help-block">
                <div style="font-size: 13px; color: red;">{{ $errors->first('email') }}</div>
            </span>
        @endif
        <br>

        <input class="btn btn-primary" type="submit" value="Save">
    </form>
</div>
@endsection
