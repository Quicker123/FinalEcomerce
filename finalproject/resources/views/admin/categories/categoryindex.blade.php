<x-admin.layout>
    <div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          <a href="{{ route('admin.categories.create') }}">Create Product</a>
          {{-- {{ Auth::user()->name }} --}}
          <table width="900" align="center">
              <tr>
                  <td>ID</td>
                  <td>Name</td>
                  <td>Category Description</td>
                  <td>Created Time</td>
              </tr>
              @foreach ($categories as $category)
                <tr>
                  <td>{{ $category->id }}</td>
                  <td> {{ $category->category_name }}</td>
                  <td> {{ substr($category->slug, 0, 50) }}</td>
                  <td>
                      {{ $category->created_at }}
                  </td>
                </tr>
              @endforeach
          </table>
        </div>
      </div>
    </div>
  </x-admin.layout>