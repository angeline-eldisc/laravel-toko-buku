@extends("layouts.global")
@section("title") Edit Order @endsection
@section("content")
<div class="col-md-8" style="margin-right:auto; margin-left:auto;">
    <h2 class="mb-3">Edit Order</h2>
    @if(session()->has('sukses'))
        <div class="alert alert-success alert-message" role="alert">
            {{ session()->get('sukses') }}
        </div>
    @endif
    
    <form class="bg-white shadow-sm p-3" action="{{route('orders.update', $order->id)}}" method="POST" autocomplete="off">
        @csrf
        {{ method_field('PUT') }}
        <label for="invoice_number">Invoice Number</label>
        <input value="{{ $order->invoice_number }}" class="form-control" type="text" name="invoice_number" id="invoice_number" disabled>
        <br>

        <label for="buyer">Buyer</label>
        <input value="{{ $order->user->name }}" class="form-control" type="text" name="buyer" id="buyer" disabled>
        <br>
        
        <label for="created_at">Created At</label>
        <input value="{{ $order->created_at }}" class="form-control" type="text" name="created_at" id="created_at" disabled>
        <br>

        <label for="books">Books ({{ $order->totalQuantity }})</label><br>
        <ul>
            @foreach($order->books as $book)
                <li>{{ $book->title }} <b>({{ $book->pivot->quantity }})</b></li>
            @endforeach
        </ul>

        <label for="total_price">Total Price</label>
        <input value="{{ $order->total_price }}" class="form-control" type="text" name="total_price" id="total_price" disabled>
        <br>

        <label for="status">Status</label>
        <br>
        <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
            <option {{ $order->status == 'SUBMIT' ? 'selected' : '' }} value="SUBMIT">SUBMIT</option>
            <option {{ $order->status == 'PROCESS' ? 'selected' : '' }} value="PROCESS">PROCESS</option>
            <option {{ $order->status == 'FINISH' ? 'selected' : '' }} value="FINISH">FINISH</option>
            <option {{ $order->status == 'CANCEL' ? 'selected' : '' }} value="CANCEL">CANCEL</option>                
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
