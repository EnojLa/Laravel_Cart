@extends('ADMIN.adminApp')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
	</div>
		<div class="col-md-4">
			<form role="form">
				<div class="form-group">
					 
				<div class="form-group">
					<label for="productname">
						Product Name
					</label>
					<input type="text" name="productname" class="form-control" id="productname" value="{{ $products->product_name }}" disabled="true" />
				</div>

				<div class="form-group">
					<label for="productdescription">
						Product Description
					</label>
					<input type="text" name="productdescription" class="form-control" id="productdescription" value="{{ $products->product_description }}" disabled="true" />
				</div>

				<div class="form-group">
					<label for="productcount">
						Product Count
					</label>
					<input type="number" name="productcount" class="form-control" id="productcount" value="{{ $products->product_count }}" disabled="true" />
				</div>

				<div class="form-group">
					<label for="productprice">
						Product Price
					</label>
					<input type="number" name="productprice" class="form-control" id="productprice" value="{{ $products->product_price }}" disabled="true" />
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
	                    <img id="image_preview_container" src="/images/{{ $products->product_image }}" 
	                        alt="preview image" style="max-height: 300px;">
	                </div>
				
				<div class="modal-footer">
					<button id="btnEdit" class="btn btn-outline-primary">Edit</button>
					<button id="btnUpdate" class="btn btn-outline-primary" disabled="true">Update</button>				
				</div>
			
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
$(document).ready(function(){
	$('#btnEdit').click(function(e){
		e.preventDefault();

		$('input').prop('disabled', false);
		$('#btnUpdate').attr('disabled', false);
		$('#btnEdit').attr('disabled', true);

});
	$('#btnUpdate').on('click', function(e){
		e.preventDefault();
		
			var id = {{ $products->id }};
			var productname = $("#productname").val();
			var productdescription = $("#productdescription").val();
			var productcount = $("#productcount").val();
			var productprice = $("#productprice").val();

	        $.ajax({
			   type:'POST',
				url:"{{ url('update-product')}}",
				data: {
						
					id: id,
					productname : productname,
					productdescription : productdescription,
				    productcount : productcount, 
				    productprice : productprice
				    
				    },

	           success:function(result){
	           				console.log(result);
				window.location.href = '/products';
				// },
				// error: function(data){
    //                 console.log(data);
                }
			});	
     });
});

</script>