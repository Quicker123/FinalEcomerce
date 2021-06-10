<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h1>Create Product</h1>
                <form action="{{ route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    Product Name: <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}"
                    @error('product_name')
                        style="border-color: red;"
                    @enderror
                    /> <br>
                    @error('product_name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                    @enderror<br>
                    Product Description: <textarea name="product_description" cols="30" rows="10" class="form-control" @error('product_description')
                    style="border-color: red;"
                @enderror>{{ old('product_description') }}</textarea><br>
                @error('product_description')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                    @enderror<br>
                <br>
                    Price: <input type="text" name="product_price" class="form-control" value="{{ old('product_price')}}" @error('product_price')
                    style="border-color: red;"
                @enderror/> <br>
                @error('product_price')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                @enderror<br>
                <br>
                <br>
                    Discount: <input type="text" name="product_discount" class="form-control" value="{{ old('product_discount')}}" @error('product_discount')
                    style="border-color: red;"
                @enderror/> <br>
                @error('product_discount')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                @enderror<br>
                <br>
                <input type="file" name="image" id=""><br><br>
                    Category: 
                    <select name="category_id" class="form-control" @error('category_id')
                    style="border-color: red;"
                @enderror>
                {{-- plain php code for listing multilevel category --}}
    
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
                    </select><br>
                    @error('category_id')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                    @enderror<br>
                    <br>
                    <button type="submit" class="form-control">Add Product</button>
                </form>
            </div>
        </div>
    </div>
    </x-admin.layout>