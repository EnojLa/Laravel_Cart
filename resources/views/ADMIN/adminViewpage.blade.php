@extends('ADMIN.adminApp')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
	</div>
		<div class="col-md-4">
			<div class="alert" id="errorlog"></div>
			<form  id="update-form">
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
					<button type="submit" class="btnUpdate btn btn-outline-primary" disabled="true">Update</button>
				</div>
			</form>
			
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){

	$('#btnEdit').click(function(e){
		e.preventDefault();

		$('input').prop('disabled', false);
		$('.btnUpdate').attr('disabled', false);
		$('#btnEdit').attr('disabled', true);

	});

	$('#update-form').submit(function(e){
		e.preventDefault();
		$('#errorlog').html("");

		var formData = new FormData(this);
		formData.append("id", {{ $products->id }});
		$.ajax({
		   type:'POST',
			url:"{{ url('update-product')}}",
			data: formData,
	        cache:false,
	        contentType: false,
	        processData: false,
	        success: (data) => {
	        	console.log(data);
	            // this.reset();
	            window.location.href = '/products';
	        },
	        error:function(error){
	           	var errors = $.parseJSON(error.responseText);
	           	console.log(error);

	            $.each(errors.errors, function(index, value) {
	            	$('#errorlog').append(value+'<br>');
	            	console.log(errors.errors);
            });
            
           }
	    });	
	        
    });
});

</script>
@endsection