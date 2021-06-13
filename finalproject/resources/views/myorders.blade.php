@extends('layout')
@section('menu')
	@include('include\menu')
@endsection
@section('contents')
<h1>My Orders</h1>
<table class="table shopping-summery">
    <thead>
        <tr class="main-hading">
            <th class="text-center">Order_Id</th>
            <th class="text-center">Payment Method</th>
            <th class="text-center">Payment Status</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($quantity as $item)
            <tr>
                <td class="image" data-title="No"><img src="{{ image_crop($item["product_image"], 100, 100, "cart") }}" alt="#"></td>
                <td class="product-des" data-title="Description">
                    <p class="product-name"><a href="#">{{ $item["product_name"]}}</a></p>
                    <p class="product-des">{{ $item["product_description"]}}</p>
                </td>
                <td class="price" data-title="Price"><span>${{ $item["unitPrice"]}}</span></td>
                <td class="qty" data-title="Qty"><!-- Input Order -->
                    <div class="input-group">
                        <div class="button minus">
                            <button type="button" data-type="minus" onclick="updateCartDetail('{{$item['product_id']}}','decrease',$('#{{ $item["product_id"] }}').val());" data-field="quant[1]">
                                <i class="ti-minus"></i>
                            </button>
                        </div>
                        <input type="text" name="product.{{ $item["product_id"] }}" id = "{{ $item["product_id"] }}" class="input-number" value="{{ $item['quantity']}}">
                        <div class="button plus">
                            <button type="button" onclick="updateCartDetail('{{$item['product_id']}}','increase',$('#{{ $item["product_id"] }}').val());" data-type="plus" data-field="quant[1]">
                                <i class="ti-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!--/ End Input Order -->
                </td>
                <td class="total-amount" id = "totalPrice{{ $item['product_id']}}" data-title="Total"><span>${{ $item["quantity"] * $item["unitPrice"]}}</span></td>
                <td class="action" data-title="Remove"><a href="#"><i class="ti-trash remove-icon"></i></a></td>
            </tr>								
        @endforeach
        
    </tbody>
</table>
@endsection