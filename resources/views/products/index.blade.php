<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container w-75">

        <ul>
            @foreach ($categories as $cate)
                <li>
                    <a href="{{ route('category.list', $cate->id) }}">
                        {{ $cate->name }}
                    </a>
                </li>
            @endforeach
        </ul>

        <h2>Danh sách sản phẩm</h2>
        <hr>
        @foreach ($products as $product)
            <div>
                <a href="{{ route('products.show', $product->id) }}">
                    <h3>{{ $product->name }}</h3>
                </a>
                <div>Category Name: {{ $product->cate_name }}</div>
                <div>Price: {{ $product->price }}</div>
                <img src="{{ $product->image }}" width="150" alt="">

            </div>
        @endforeach

        {{ $products->links() }}
    </div>
</body>

</html>
