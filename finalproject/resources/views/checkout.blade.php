@extends('layout')
@section('menu')
	@include('include\menu')
@endsection
@section('contents')		


			
	<!-- Start Checkout -->
	<section class="shop checkout section">
		<div class="container">
			<div class="row"> 
				<div class="col-lg-8 col-12">
					<div class="checkout-form">
						<h2>Make Your Checkout Here</h2>
						<!-- Form -->
						<form class="form" method="POST" action="/user/transaction">
							@csrf
							<div class="row">
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>Name<span>*</span></label>
										<input type="text" name="name" placeholder="" required="required" value={{ Auth::user()->name }}>
									</div>
									@error('name')
										<div class="alert alert-danger">
											{{ $message }}
										</div>
									@enderror
									
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>Email Address<span>*</span></label>
										<input type="email" name="email" placeholder="" required="required" value={{ Auth::user()->email }}>
									</div>
									@error('email')
										<div class="alert alert-danger">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>Phone Number<span>*</span></label>
										<input type="text" name="number" placeholder="" required="required" value="{{ old('number')}}">
									</div>
									@error('number')
										<div class="alert alert-danger">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>Address Line 1<span>*</span></label>
										<input type="text" name="address" placeholder="" required="required" value="{{ old('address')}}">
									</div>
									@error('address')
										<div class="alert alert-danger">
											{{ $message }}
										</div>
									@enderror
								</div>
								<input type="hidden" value={{ $orders->id }} name="order_id">
									<div class="single-widget get-button" style="margin-top: 30px; margin-left: 270px;">
										<div class="button">
											<input type="submit" value="Pay With Cash" style="padding: 10px;">
										</div>
									</div>
							</div>
						</form>
						<!--/ End Form -->
					</div>
				</div>
				<div class="col-lg-4 col-12">
					<div class="order-details">
						<!-- Order Widget -->
						<div class="single-widget">
							<h2>CART  TOTALS</h2>
							<div class="content">
								<ul>
									<li>Sub Total<span>${{$orders->order_status == "checkout"? "0" : $orders->order_total}}</span></li>
									<li>(+) Shipping<span>${{$orders->order_status == "checkout" ? "0" : $orders->shipping_price}}</span></li>
									<li class="last">Total<span>${{$orders->order_status == "checkout" ? "0" : $orders->order_total + $orders->shipping_price }}</span></li>
								</ul>
							</div>
						</div>
						<!--/ End Order Widget -->
						<!-- Payment Method Widget -->
						<div class="single-widget payement">
							<div class="content">
								<img src="/images/payment-method.png" alt="#">
							</div>
						</div>
						<!--/ End Payment Method Widget -->
						<!-- Button Widget -->
						<div class="single-widget get-button">
							<div class="content">
								<div class="button">
									<button id="khalti-pay" style="padding: 10px;">Pay with Khalti</button>
								</div>
								<div id="successMessage">
								</div>
							</div>
						</div>
						<!--/ End Button Widget -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ End Checkout -->
	
	<!-- Start Shop Services Area  -->
	<section class="shop-services section home">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Services -->
	
@endsection