@extends('layout')
@section('menu')
	@include('include\menu')
@endsection
@section('contents') 
<section class="blog-single section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-12">
        <div class="blog-single-main">
          <div class="row">
            <div class="col-12">
              <div class="image" style="height: 400px">
                <img class="default-img" src="{{ $singleproduct->product_image == ' ' ? 'https://via.placeholder.com/950x460': image_crop($singleproduct->product_image, 550, 460, "productdetail") }}" alt="#">
                {{-- <img class="hover-img" src="{{ $singleproduct->product_image == ' ' ? 'https://via.placeholder.com/950x460': asset('storage/images/productdetail/'.$singleproduct->product_image) }}" alt="#"> --}}
              </div>
            </div>
            <div class="col-12">
              <div class="comments">
                <h3 class="comment-title">Comments (  {{ $productComments->count() }})</h3>
                <!-- Single Comment -->
                @foreach ($productComments as $comment)
                  <div class="single-comment">
                    <img src="https://via.placeholder.com/80x80" alt="#">
                    <div class="content">
                      <h4>{{ $comment->name }}<span>created at: {{ $comment->created_at }}</span></h4>
                      <p>{{ $comment->message }}</p>
                      <div class="button">
                        <a href="#" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>
                      </div>
                    </div>
                  </div>                   
                @endforeach
                {{-- This is the reply comment section --}}
                {{-- <div class="single-comment left">
                  <img src="https://via.placeholder.com/80x80" alt="#">
                  <div class="content">
                    <h4>john deo <span>Feb 28, 2018 at 8:59 pm</span></h4>
                    <p>Enthusiastically leverage existing premium quality vectors with enterprise-wide innovation collaboration Phosfluorescently leverage others enterprisee  Phosfluorescently leverage.</p>
                    <div class="button">
                      <a href="#" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>
                    </div>
                  </div>
                </div> --}}

              </div>									
            </div>											
            <div class="col-12">			
              <div class="reply">
                <div class="reply-head">
                  <h2 class="reply-title">Leave a Comment</h2>
                  <!-- Comment Form -->
                  <form class="form" action="{{ route('userproduct.store', ['id'=> $singleproduct->id ])}}" method="POST">
                    @csrf
                    <input name="product_id" value='{{ $singleproduct->id }}' type="hidden" >
                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                          <label>Your Name<span>*</span></label>
                          <input type="text" name="visitor_name" placeholder="" required="required">
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                          <label>Your Email<span>*</span></label>
                          <input type="email" name="visitor_email" placeholder="" required="required">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label>Your Message<span>*</span></label>
                          <textarea name="visitor_message" placeholder=""></textarea>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group button">
                          <button type="submit" class="btn">Post comment</button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!-- End Comment Form -->
                </div>
              </div>			
            </div>			
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-12">
        <div class="main-sidebar">
          <!-- Single Widget -->
          <div class="single-widget category">
            <h3 class="title">Product Detail</h3>
            <ul class="categor-list">
              <li><b>Product Name: {{ $singleproduct->product_name }}</b></li>
              <li><b> Description:</b> <pre>{{ $singleproduct->product_description}}</pre></li>
              <li><b> Actual Price:</b> Rs.{{ $singleproduct->product_price }}</li>
              <li><b> Discount:</b> {{$singleproduct->product_discount}}%</li>
              <li><b>Discounted Price:</b> Rs.{{ $singleproduct->product_price - ($singleproduct->product_price * ($singleproduct->product_discount / 100))}}</li>
              <li>
                <form action="#">
                  <div class="form-group button rounded">
                    <button type="submit" class="btn">Add to Cart</button>
                  </div>
                </form>
              </li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</section>		
@endsection
