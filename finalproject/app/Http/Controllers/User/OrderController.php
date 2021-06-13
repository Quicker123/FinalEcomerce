<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Psy\VersionUpdater\Checker;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(){
        $products = Product::all();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $orders = Order::where('order_user_id', Auth::id())->latest()->first();
        if($orders === null){
            $quantity = [];
            $orders = [];
            return view('home', compact(['products', 'categories', 'subcategories', 'orders', 'quantity']));
        }
        $quantity= $this->holder();
        return view('home', compact(['products', 'categories', 'subcategories', 'orders', 'quantity']));
    }
    public function index()
    {
        $quantity= $this->holder();
        $orders = Order::where('order_user_id', Auth::id())->latest()->first();
        $products = Product::latest()->with('category')->get();
        $categories = Category::all();
        return view('cart', compact(['products', 'categories', 'quantity', 'orders']));
    }

    public function holder(){
        $checker = Order::where('order_user_id', Auth::id())->latest()->first();
        $storage = $checker->items;
        $quantity = [];
        foreach($storage as $item){
            $product_quantity = $item->product_quantity;
            $product= Product::find($item->product_id);
            $unitPrice = $product->product_price - ($product->product_price * ($product->product_discount / 100));
            $product_description = $product->product_description;
            $product_name = $product->product_name;
            $product_id = $item->product_id;
            $product_image = $product->product_image;
            $a1 = ["product_name"=>$product_name, "product_description"=>$product_description, "product_id"=>$product_id,
                    "quantity" => $product_quantity, "unitPrice"=>$unitPrice, "product_image"=> $product_image];
            array_push($quantity, $a1);
        }
        return $quantity;
    }

    public function OrderItem(Request $request){
        $checker = Order::where('order_user_id', Auth::id())->latest();
        $order_status = $checker ? $checker->order_status : "nothing";
        $order = Order::all();
        if($order->count() === 0 || $order_status == "checkout"){
            $this->create();
        }    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $uniqueId = rand(1000, 10000);
        $order = new Order;
        $order->unique_id = $uniqueId;
        $order->order_user_id = Auth::id();
        $order->order_total = 0;
        $order->payment_method = "nothing";
        $order->shipping_price = 10;
        $order->order_status = 'cart';
        return $order->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'quantity'=> 'required|integer',
        ]);
        $order_status = "";
        $checker1 = Order::where('order_user_id', Auth::id())->latest()->first();
        if($checker1 != null){
            $order_status = $checker1->order_status;
        }else{
            $this->create();
        }
        
        $order = Order::all();
        if($order->count() === 0 || $order_status == "checkout"){
            $this->create();
        }
        $checker = Order::where('order_user_id', Auth::id())->latest()->first(); 
        //getting the request from the user.
        $quantity = $request->quantity;
        $product_id = $request->product_id;

        $product = Product::find($product_id);

        $finalPrice = $product->product_price - ($product->product_price * ($product->product_discount / 100));
        //adding orderItem
        $productChecker = OrderItem::where('order_id', $checker->id)->where('product_id', $product_id)->first();
        if($productChecker){
            $productChecker->product_quantity = $quantity;
            $productChecker->save();
            $productChecker->product_total_price = $quantity * $finalPrice;
            $productChecker->save();
        }else{
            $orderItem = new OrderItem;
            $orderItem->order_id = $checker->id;
            $orderItem->product_id = $product_id;
            $orderItem->product_price = $finalPrice;
            $orderItem->product_quantity = $quantity;
            $orderItem->product_total_price = $quantity * $finalPrice;
            $orderItem->save();
        }
        // $checker->order_total =
        $holder = $checker::withSum('items', 'product_total_price')->where('order_user_id' , Auth::id())->latest()->first();
        $checker->order_total = $holder->items_sum_product_total_price;
        $checker->save();
        return redirect()->route('user.order.index');
    }

    public function ajaxRequest(Request $request){
            $product_id = $request->id;
            $quantity = $request->count;
            $type = $request->type;
            $order = Order::select('id')->where('order_user_id', Auth::id())->latest()->first();
            $orderItem = OrderItem::where('product_id', $product_id)->where('order_id', $order->id)->latest()->first();
            if($type = 'increase'){
                $orderItem->product_quantity = $quantity + 1;
                $orderItem->save();
            }elseif($type = 'decrease'){
                $orderItem->product_quantity = $quantity - 1;
                $orderItem->save();
            }
            $finalQuantity = $orderItem->product_quantity;
            $orderItem->product_total_price = $finalQuantity * $orderItem->product_price;
            $orderItem->save();
    
            $totalAmount = $orderItem->product_total_price;

            return response()->JSON([
                'message'=>'cart updated',
                'status' => 200,
                'count'  => $finalQuantity, 
                'total'  => $totalAmount,
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
