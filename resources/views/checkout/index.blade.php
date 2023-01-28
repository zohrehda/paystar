@extends('layouts.app')

@section('main')

<div class="py-5 text-center">
	<h2>Checkout form</h2>
</div>

<div class="row g-5">
	<div class="col-7">
		<h4 class="d-flex justify-content-between align-items-center mb-3">
			<span class="text-primary">Your Order</span>
			<span class="badge bg-primary rounded-pill">1</span>
		</h4>
		<ul class="list-group mb-3">
			<li class="list-group-item d-flex justify-content-between lh-sm">
				<div>
					<h6 class="my-0">{{$order->product->title}}</h6>
					<small class="text-muted">Brief description</small>
				</div>
				<span class="text-muted">{{$order->product->amount}}</span>
			</li>


			<li class="list-group-item d-flex justify-content-between">
				<span>Total (IR)</span>
				<strong>{{$order->product->amount}}</strong>
			</li>
		</ul>

	</div>
	<div class="col-md-5  ">
		<form class="needs-validation" novalidate method="post">
			@csrf
			<input type="hidden" name="order_id" value="{{$order->id}}">
			<div class="row gy-3">

				<div class="col-md-12">
					<label for="cc-number" class="form-label">Credit card number</label>
					<input type="text" name="credit_card_number" class="form-control" id="cc-number" placeholder="" required>
				</div>

			</div>

			@foreach($errors->all() as $error)
			<div class="invalid-feedback">
				{{$error}}
			</div>
			@endforeach

			<hr class="my-4">
			<button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
		</form>
	</div>
</div>

@endsection()