@extends("layouts.global")
@section("title") Detail User @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Detail User</h2>
    <div class="card">
        <div class="card-body">
            <b>Name : </b><br>
            {{ $user->name }}
            <br><br>

            @if($user->avatar)
                <img src="{{ asset('images/avatars/'.$user->avatar) }}" alt="avatar" width="128">
            @else
                No Avatar
            @endif
            <br><br>

            <b>Username : </b><br>
            {{ $user->username }}
            <br><br>

            <b>Phone Number</b><br>
            {{ $user->phone }}
            <br><br>
            
            <b>Address</b><br>
            {{ $user->address }}
            <br><br>

            <b>Roles : </b><br>
            <ul>
                @foreach (json_decode($user->roles) as $role)
                    <li style="margin-left: -2%;">{{$role}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
