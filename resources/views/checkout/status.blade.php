@extends('layouts.app')

@section('main')

<div class="py-5 text-center">
	<h2>Checkout status</h2>
</div>

<div class="row g-5  d-flex justify-content-center">
	<div class="col-7 ">

		<ul class="list-group mb-3">

			<li class="list-group-item d-flex justify-content-between lh-lg">
				<span>status</span>
				@if($transaction->success )
				<span class="text-success">success</span>
				@else
				<span class="text-danger">failed</span>
				@endif
			</li>

			<li class="list-group-item d-flex justify-content-between lh-lg">
				<span>ref number</span>
				<span class="text-muted">{{ $transaction->ref_num }}</span>
			</li>

			@if($transaction->success )

			<li class="list-group-item d-flex justify-content-between lh-lg">
				<span>tracking code</span>
				<span class="text-muted">{{ $transaction->tracking_code }}</span>
			</li>

			@endif



		</ul>

	</div>

</div>

@endsection()