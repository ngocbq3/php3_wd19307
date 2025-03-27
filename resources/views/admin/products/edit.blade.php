@extends('admin.layout')

@section('title', 'Cập nhật sản phẩm')

@section('content')
    @session('message')
        <div class="alert bg-success text-white">
            {{ session('message') }}
        </div>
    @endsession
    <div class="container w-75">
        <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="" class="form-label">Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Image</label> <br>
                <img src="{{ Storage::URL($product->image) }}" width="100" alt="">
                <input type="file" name="image" id="" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Category</label>
                <select name="category_id" id="" class="form-control">
                    @foreach ($categories as $cate)
                        <option value="{{ $cate->id }}" @selected($cate->id == $product->category_id)>
                            {{ $cate->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Price</label>
                <input type="number" name="price" step="0.1" value="{{ $product->price }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Stock</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Description</label>
                <textarea name="description" rows="10" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">List</a>
            </div>
        </form>
    </div>
@endsection
