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
                    Category Description: <textarea name="category_slug" cols="30" rows="10" class="form-control" @error('category_slug')
                    style="border-color: red;"
                @enderror>{{ old('category_slug') }}</textarea><br>
                @error('category_slug')
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