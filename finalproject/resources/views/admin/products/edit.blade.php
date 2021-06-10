<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h1>Update Product {{ $products->product_name }}</h1>
                <form action="{{ route('admin.products.update', ['product' => $products->id ]) }}" method="POSt" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    Product Name: <input type="text" name="product_name" class="form-control" value="{{ $products->product_name}}"/> <br><br>
                    Product Description: <textarea name="product_description" cols="30" rows="10" class="form-control">{{ $products->product_description }}</textarea><br><br>
                    Price: <input type="text" name="product_price" value="{{ $products->product_price }}" class="form-control"/> <br><br>
                    Discount: <input type="text" name="product_discount" class="form-control" value="{{ $products->product_discount }}" ><br><br>
                    <input type="file" name="image" id=""><br><br>
                    Category: 
                    <select name="category_id" class="form-control" @error('category_id')
                    style="border-color: red;"
                @enderror>
                    <option value = "0">Select a Category</option>
                    <?php
                        foreach($categories as $category){
                    ?>
                    <option value="{{ implode(",", [$category->category_name, $category->id])}}" {{ $category->id == old('category_id') ? "selected" : ''}}>{{ $category->category_name}}</option>
                    <?php        
                    foreach($subcategories as $subcategory){
                    ?>
                    @if ($subcategory->parent_category == $category->id)
                        <option value="{{ implode(",", [$subcategory->category_name, $subcategory->id])  }}" {{ $subcategory->id == old('category_id') ? "selected" : ''}}>-----{{ $subcategory->category_name}}</option>
                    @endif                    
                    <?php       
                            }
                        }
                    ?>  
                    </select><br><br>
                    <button type="submit" class="form-control">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-admin.layout>