@extends('USER.userApp')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center text-muted">
				Laravel Cart
			</h3>
		</div>
	</div>
	<br><br>
	<div class="row">
	@foreach($products as $row)
		<div class="col-md-15">
			<img alt="preview image" style="max-height: 150px; margin: 3px;" class="rounded img-thumbnail" src="/images/{{ $row->product_image }}"/>
				<p style="text-align: justify;">{{ $row->product_description }}</p>
				<p style="text-align: justify;">Php {{ $row->product_price }}</p>
				<p style="text-align: justify;">{{ $row->product_count }} available stocks</p>
			<button id="{{ $row->id }}" href="#modal-container-406137" type="button" class="btn btnBuy btn-outline-secondary btn-sm" data-toggle="modal">Buy</button>
			</div>
			@endforeach

			<div class="modal fade" id="modal-container-406137" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								Product Review
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="prodId" id="prodId">
						    <label>Product Name: <p id="prodName"></p></label><br>
							<label>Product Description: <p id="prodDesc"></p></label><br>
							<label>Availabe stock: <p id="prodCount"></p></label><br>
							<label>Product Price: <input id="prodPrice" disabled="true" /></label>
							<img src="" id="prodImage" style="max-height: 150px; display: block; margin-left: auto; margin-right: auto; width: 50%; ">
							<label>Quantity: <input type="number" id="prodQuantity" value="1" min="1" max="100"></label>
							<p>Total: Php<output id="total"></output></p>
						</div>
						<div class="modal-footer">
							 
							<button type="button" class="btn btnAddtocart btn-primary" data-dismiss="modal">
								Add to cart
							</button> 
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Cancel
							</button>
						</div>
					</div>
					
				</div>
				
			</div>
			
		</div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
	$('.btnBuy').click(function(e){
		e.preventDefault();

			var id = this.id;
	
			$.ajax({
				url: "show-product",
				type: 'GET',
				data: {id:id},

				success:function(data){
					$('#prodId').val(data.id);
					$('#prodName').text(data.product_name);
					$('#prodDesc').text(data.product_description);
					$('#prodCount').text(data.product_count);
					$('#prodPrice').val(data.product_price);
					$('#prodImage').attr('src', '/images/'+data.product_image);
					comp();
				}
			});

	});
	function comp () {
		var prodPrice = $('#prodPrice').val();
		var prodQuantity = $('#prodQuantity').val();
		var totalPrice = prodPrice * prodQuantity;

		var total = $('#total').text(totalPrice);
		
	}
	$("#prodQuantity").keyup(function(){
	  	comp();
	});
	
	$('.btnAddtocart').on('click', function(){

		var id = $('#prodId').val();
		var prodName = $('#prodName').text();
		var prodDesc = $('#prodDesc').text();
		var prodCount = $('#prodCount').text();
		var prodQuantity = $('#prodQuantity').val();
		var prodPrice = $('#prodPrice').val();
		var total = $('#total').text();

		if (prodQuantity <= 0) {
				alert('Please input atleast 1 quantity!!!');
		}else if
			(prodCount == 0) {
				alert('Out of stocks! Please choose another item');
		}else if 
			(prodQuantity > prodCount) {
			alert(prodCount + ' is avalibale stocks')
		}else{	

			$.ajax({

				type:'POST',
				url: "{{ url('add-to-cart')}}",
				data: {
						
						id,
						prodName,
						prodDesc,
						prodQuantity,
						prodPrice,
						total
					},

					success:function(item){
						alert('Item added to cart');
						location.reload(true);

					}

			});
		}
	});

});		
</script>
@endsection