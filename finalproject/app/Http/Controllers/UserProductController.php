<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\SubCategory;
class UserProductController extends Controller
{
    //
    public function index($id){
        $products = Product::all();
        $singleproduct = Product::find($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $productComments = $singleproduct->comment;
        return view('productDetail',  compact(['products', 'categories', 'subcategories', 'singleproduct', 'productComments']));
    }
    public function store (Request $request){
        $product_id = $request->product_id;
        $name = $request->visitor_name;
        $email = $request->visitor_email;
        $message = $request->visitor_message;


        $productComment = new ProductComment;
        $productComment->name = $name;
        $productComment->email = $email;
        $productComment->message = $message;
        $productComment->product_id = $product_id;
        $productComment->save();

        return redirect()->route('userproduct.index', ['id'=>$product_id]);
    }
}
