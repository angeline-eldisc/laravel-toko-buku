@extends("layouts.global")
@section("title") Users List @endsection
@section("content")
<div class="col-md-11" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Users List</h2>
    <form action="{{route('users.index')}}" autocomplete="off">
        <div class="row">
            <div class="col-md-6" style="padding-right: 0px;">
                <div class="input-group mb-3">
                    <input value="{{Request::get('keyword')}}" name="keyword" class="form-control col-md-12 float-right" type="text" placeholder="Filter berdasarkan email" style="width: 100%!important;">
                </div>
            </div>
            <div  class="col-md-6 mb-3">
                <input {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}} value="ACTIVE" name="status" type="radio" class="form-control" id="active"> <label for="active">Active</label> 
                <input {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}} value="INACTIVE" name="status" type="radio" class="form-control" id="inactive"> <label for="inactive">Inactive</label>
                
                <input type="submit" value="Filter" class="btn btn-primary">
            </div>
        </div>
        <hr style="margin: 1% 0px;">
        <div class="row">
            <div class="col">
                <a class="btn btn-primary text-white btn-sm mb-3 mt-1 float-left" href="{{route('users.create')}}">Create User</a>
            </div>
            <div class="col">
                <a class="btn btn-warning text-white btn-sm mb-3 mt-1 float-right" href="{{route('users.index')}}">Refresh</a>
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
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><b>Name</b></th>
                    <th><b>Username</b></th>
                    <th><b>Email</b></th>
                    <th><b>Avatar</b></th>
                    <th><b>Status</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @if($users->count() > 0)
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->avatar)
                                    <img src="{{ asset('images/avatars/'.$user->avatar) }}" alt="avatar" width="76">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($user->status ==  "ACTIVE")
                                    <span class="badge badge-success">
                                        {{$user->status}}
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        {{$user->status}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-info text-white btn-sm mb-2" href="{{route('users.edit', $user->id)}}">Edit</a>
                                <a class="btn btn-primary text-white btn-sm mb-2" href="{{route('users.show', $user->id)}}">Detail</a>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                    Delete
                                </button>
                                
                                <form id="delete-user-modal" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
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
                            {{$users->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>

<div class="modal faster animated zoomIn" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <p>Once deleted, you won't be able to restore this file!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                <button type="buttom" class="btn btn-danger btn-lg" onclick="event.preventDefault(); document.getElementById('delete-user-modal').submit();">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection
