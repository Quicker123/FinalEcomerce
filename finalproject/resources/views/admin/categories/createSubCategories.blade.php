<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h1>Create Category</h1>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    Category Name: <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}"
                    @error('category_name')
                        style="border-color: red;"
                    @enderror
                    /> <br>
                    @error('category_name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                    @enderror<br>
                    Category Description: <textarea name="category_description" cols="30" rows="10" class="form-control" @error('category_description')
                    style="border-color: red;"
                @enderror>{{ old('category_description') }}</textarea><br>
                @error('category_description')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                    @enderror<br>
                <br>
                    Category: 
                    <select name="category_id" class="form-control" @error('category_id')
                    style="border-color: red;"
                @enderror>
                        <option value = "0">Select a Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? "selected" : ''}}>{{ $category->category_name}}</option>
                        @endforeach
                    </select><br>
                    @error('category_id')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>                    
                    @enderror<br>
                    <br>
                    <button type="submit" class="form-control">Save</button>
                </form>
            </div>
        </div>
    </div>
    </x-admin.layout>