@extends("layouts.global")
@section("title") Orders List @endsection
@section("content")
<div class="col-md-11" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-2">Orders List</h2>
    <form action="{{route('orders.index')}}" autocomplete="off">
        <div class="row">
            <div class="col-md-5 mb-2" style="padding-right: 0px; margin-right: 16px;">
                <div class="input-group">
                    <input value="{{Request::get('buyer_email')}}" name="buyer_email" class="form-control col-md-12 float-right" type="text" placeholder="Search by buyer's email" style="width: 100%!important;">
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <select name="status" class="form-control" id="status">
                    <option value="">ANY</option>
                    <option {{ Request::get('status') == "SUBMIT" ? "selected" : "" }} value="SUBMIT">SUBMIT</option>
                    <option {{ Request::get('status') == "PROCESS" ? "selected" : "" }} value="PROCESS">PROCESS</option>
                    <option {{ Request::get('status') == "FINISH" ? "selected" : "" }} value="FINISH">FINISH</option>
                    <option {{Request::get('status') == "CANCEL" ? "selected" : "" }} value="CANCEL">CANCEL</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <input type="submit" value="Filter" class="btn btn-primary">
            </div>
        </div>
    </form>

    <hr style="margin: 1% 0px;">
    <div class="row">
        <div class="col">
            <a class="btn btn-primary text-white btn-sm mb-3 mt-1 float-left" href="{{route('orders.create')}}">Create Order</a>
        </div>
        <div class="col">
            <a class="btn btn-warning text-white btn-sm mb-3 mt-1 float-right" href="{{route('orders.index')}}">Refresh</a>
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
                    <th><b>Invoice Number</b></th>
                    <th><b>Status</b></th>
                    <th><b>Buyer</b></th>
                    <th><b>Total Quantity</b></th>
                    <th><b>Order Date</b></th>
                    <th><b>Total Proce</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_number }}</td>
                            <td>
                                @if($order->status ==  "SUBMIT")
                                    <span class="badge badge-warning text-light">
                                        {{$order->status}}
                                    </span>
                                @elseif($order->status == "PROCESS")
                                    <span class="badge badge-info text-light">
                                        {{$order->status}}
                                    </span>
                                @elseif($order->status == "FINISH")
                                    <span class="badge badge-success text-light">
                                        {{$order->status}}
                                    </span>
                                @elseif($order->status == "CANCEL")
                                    <span class="badge badge-dark text-light">
                                        {{$order->status}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $order->user->name }}<br>
                                <small>{{$order->user->email}}</small>
                            </td>
                            <td>{{ $order->totalQuantity }} Pc(s)</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>
                                <a class="btn btn-info text-white btn-sm mb-2"  href="{{route('orders.edit', $order->id)}}">Edit</a>
                                <a class="btn btn-primary text-white btn-sm mb-2"  href="{{route('orders.show', $order->id)}}">Detail</a>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#deleteorderModal">
                                    Delete
                                </button>
                                
                                <form id="delete-order-modal" action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center">No record found.</td>
                </tr>
                @endif
                <tfoot>
                    <tr class="pt-2">
                        <td colspan="10">
                            {{$orders->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>

<div class="modal faster animated zoomIn" id="deleteorderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="buttom" class="btn btn-danger btn-lg" onclick="event.preventDefault(); document.getElementById('delete-order-modal').submit();">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection
