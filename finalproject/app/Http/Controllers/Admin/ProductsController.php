<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.products.create', compact(['categories', 'subcategories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'=>'required|max:255',
            'product_description'=>'required',
            'product_price'=>'required',
            'category_id'=>'required|string|min:2',
            'product_discount'=>'required|integer'
        ]);
        $storage = explode(",", $request->category_id);
        $category = DB::table("categories")->where('category_name', $storage[0])
                                            ->first();
        $subcategory = SubCategory::where('category_name', $storage[0])->first();
        if($category){
            $newcategory = $storage[1];
            $subcategory = 0;
        }else if($subcategory){
            $newcategory = $subcategory->parent_category;
            $subcategory = $storage[1];            
        }
        $product = new Product;
            $product->category_id = $newcategory;
            $product->user_id = Auth::id();
            $product->subcategory_id = $subcategory;
            $product->product_name = $request->input('product_name');
            $product->product_description = $request->input('product_description');
            if($request->hasFile("image")){
                $name = $request->file('image')->getClientOriginalName();
                $newname = $this->imageUnique($name);
                $request->file('image')->storeAs('public/images', $newname);
                image_crop($newname, 550, 750, 'thumbnail');
                $product->product_image = $newname;
            }
            $product->product_discount = $request->product_discount;
            $product->product_price = $request->product_price; 
            if($product->save()){
                return redirect()->route('admin.products.index');
            } else{
                return redirect()->back();
            }
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
        $products = Product::find($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.Products.edit', compact(['products', 'categories', 'subcategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageUnique($file){
        $holder =  explode(".", $file);
        $changer = $holder[0].date("h_i_sa");
        $holder[0] = $changer;
        $newholder = implode(".", $holder);
        return $newholder;
    }
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'product_name'=>'required|max:255',
            'product_description'=>'required',
            'product_price'=>'required',
            'category_id'=>'required|string|min:2',
            'product_discount'=>'required|integer'
        ]);
        $storage = explode(",", $request->category_id);
        $category = DB::table("categories")->where('category_name', $storage[0])
                                            ->first();
        $subcategory = SubCategory::where('category_name', $storage[0])->first();
        if($category){
            $newcategory = $storage[1];
            $subcategory = 0;
        }else if($subcategory){
            $newcategory = $subcategory->parent_category;
            $subcategory = $storage[1];            
        }
        $product = Product::findOrfail($id);
        $product->product_name = $request->input('product_name');
        $product->product_description = $request->input('product_description');
        $product->product_price = $request->input('product_price');
        if($request->hasFile("image")){
            $name = $request->file('image')->getClientOriginalName();
            $newname = $this->imageUnique($name);
            $request->file('image')->storeAs('public/images', $newname);
            $product->product_image = $newname;
        }
        $product->category_id = $newcategory;
        $product->subcategory_id = $subcategory;
        $product->save();
        return redirect()->route('admin.products.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return back(); 
    }
}
