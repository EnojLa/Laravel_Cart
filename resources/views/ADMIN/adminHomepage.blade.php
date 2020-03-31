@extends('ADMIN.adminApp')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-outline-success btn-sm" href="#modal-container-115163" data-toggle="modal">New Product</button>
			
			<div class="modal fade" id="modal-container-115163" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								New Product
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">

								<div class="form-group">
									<label for="productname">
										Product Name
									</label>
									<input type="text" class="form-control" id="productname"/>
								</div>

								<div class="form-group">
									 
									<label for="productimage">
										Product Image
									</label>
									<input type="text" class="form-control" id="productimage"/>
								</div>

								<div class="form-group">
									<label for="productdescription">
										Product Description
									</label>
									<input type="text" class="form-control" id="productdescription"/>
								</div>

								<div class="form-group">
									<label for="productcount">
										Product Count
									</label>
									<input type="number" class="form-control" id="productcount"/>
								</div>

								<div class="form-group">
									<label for="productprice">
										Product Price
									</label>
									<input type="number" class="form-control" id="productprice"/>
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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<table id="myTable" class="table table-hover">
				<thead>
					<tr>
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
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><button>View</button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
     
    $(document).ready(function (e) {
  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
 
        $('#image').change(function(){
          
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#image_preview_container').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
 
        });
 
        $('#upload_image_form').submit(function(e) {
            e.preventDefault();
 
            var formData = new FormData(this);
 
            $.ajax({
                type:'POST',
                url: "{{ url('add-products')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    alert('Image has been uploaded successfully');
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    });
 
</script>