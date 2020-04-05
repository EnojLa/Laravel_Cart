@extends('USER.userApp')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">
				Purchased Item
				<table id="myTable" class="table table-hover">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Product Description</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						@foreach($purchase as $item)
						<tr>
							<td>{{ $item->product_name }}</td>
							<td>{{ $item->product_description }}</td>
							<td>{{ $item->product_quantity }}</td>
							<td>{{ $item->product_total }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		<div class="col-md-1"></div>
	</div>
</div>
@endsection