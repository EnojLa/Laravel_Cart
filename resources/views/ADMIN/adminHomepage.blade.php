@extends('ADMIN.adminApp')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-15">	 
			<button type="button" class="btn btn-outline-success btn-sm" href="#modal-container-115163" data-toggle="modal">New Product</button>
		</div>
	</div>
</div><br>
<div class="container">
	<div class="row">
		<div class="col-md-12">	
			<div class="modal fade" id="modal-container-115163" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								New Product
							</h5> 
						</div>

						<div class="modal-body">
							<form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">

								<div class="form-group">
									<label for="productname">
										Product Name
									</label>
									<input type="text" name="productname" class="form-control" id="productname"/>
								</div>

								<div class="form-group">
									<label for="productdescription">
										Product Description
									</label>
									<input type="text" name="productdescription" class="form-control" id="productdescription"/>
								</div>

								<div class="form-group">
									<label for="productcount">
										Product Count
									</label>
									<input type="number" name="productcount" class="form-control" id="productcount" min="1" max="100" />
								</div>

								<div class="form-group">
									<label for="productprice">
										Product Price
									</label>
									<input type="number" name="productprice" class="form-control" id="productprice"/>
								</div>

								<div class="form-group">
									<label for="exampleInputFile">
										Product Image
									</label>
									<input type="file" name="image" placeholder="Choose image" id="image">
				                        <span class="text-danger">{{ $errors->first('title') }}</span>
								</div>

								<div class="row">
					                <div class="col-md-12 mb-2">
					                    <img id="image_preview_container" src="{{ asset('public/image/image-preview.png') }}" 
					                        alt="preview image" style="max-height: 150px;">
					                </div>
								
								<div class="modal-footer">
								<button type="submit" class="btn btn-primary">
									Add Product
								</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Cancel
							</button>
							</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table id="myTable" class="table table-hover">
				<thead>
					<tr>
						<th>Product</th>
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Product Image</th>
						<th>Product Description</th>
						<th>Product Count</th>
						<th>Product Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $product)
					<tr>
						<td><img id="image_preview_container" src="/images/{{ $product->product_image }}" 
	                        alt="preview image" style="max-height: 50px;"></td>
						<td>{{ $product->product_code }}</td>
						<td>{{ $product->product_name }}</td>
						<td>{{ $product->product_image }}</td>
						<td>{{ $product->product_description }}</td>
						<td>{{ $product->product_count }}</td>
						<td>{{ $product->product_price }}</td>
						<td><a href="view-products/{{ $product->id }}"><button type="button" class="btn btn-outline-secondary btn-sm">View</button><button id="{{ $product->id }}" type="button" class="btn btnDel btn-outline-danger btn-sm">Delete</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
	$('.btnDel').click(function(e){
		e.preventDefault();

		var id = this.id;
		console.log(id);
		var del = confirm('Do you want to delete this Item?');

			if(del == true) {

				$.ajax({

					type: 'POST',
					url: "{{ url('delete') }}",
					data: {
						id:id
					},
					success:function(del) {
						location.reload(true);
					}
					

				});
			
			}

		});
});
</script>
@endsection
