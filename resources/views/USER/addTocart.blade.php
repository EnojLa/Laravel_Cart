@extends('USER.userApp')

{{ dd(Session::all()) }}

{{-- @section('content')

@foreach(Session::get('cart') as $carts)

	@foreach($carts as $cart)
		{{ $cart }}

	@endforeach
	<br>
@endforeach

@endsection --}}