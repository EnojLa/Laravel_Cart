@extends('USER.userApp')

@section('content')

@php
$total = 0;
@endphp
<div class="container">
	<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">
				@if(Session::exists('cart'))
				My Cart
				<table id="myTable" class="table table-hover">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach(Session::get('cart') as $carts)
						<tr>
							<td>{{ $carts['prodName'] }}</td>
							<td>{{ $carts['prodQuantity'] }}</td>
							<td>{{ $carts['total'] }}</td>
							<td><button id="{{ $carts['id'] }}" type="button" class="btn btnDel btn-outline-danger btn-sm">Remove</button></td>
						</tr>
						@php
							$total = $carts['total'] + $total;
						@endphp
						@endforeach
					</tbody>
					<thead>
						<tr>
							<th>Sub Total</th>
							<th></th>
							<th>{{ $total }}</th>
							<th><button type="button" class="btn btnCheckout btn-outline-success btn-sm">Check Out</button></th>
						</tr>
					</thead>
				</table>
				@else <h3>Please add Item!</h3>
				@endif
			</div>
		<div class="col-md-1"></div>
	</div>
</div>
@endsection
@section('scripts')

<script>
$('.btnCheckout').click(function(e){
	e.preventDefault();

	alert('Purchasing product completed!');

	$.ajax({
	    type: 'POST',
	    url: 'checkout',
	    success: function(success) {
	        window.location.href = 'dashboard';
	    }
	});
});
$('.btnDel').click(function(e){
	e.preventDefault();

	let id = this.id;
	var del = confirm('Do you want to delete this Item?');

		if(del == true) {
		
			$.ajax({
			    type: 'POST',
			    url: 'remove',
			    data: {
			    	id
			    },
			    success: function(success) {
			        console.log(success);
			        location.reload(true);
			    }
			});

		}
});

</script>
@endsection
