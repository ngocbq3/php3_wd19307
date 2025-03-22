<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyProductController;
use App\Http\Controllers\ProductController;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return "Trang chủ";
});

//đường dẫn có tham số
// Route::get('/products/{id}', function ($id) {
//     return "Sản phẩm có ID: " . $id;
// });
//Nhiều tham số
Route::get('/categories/{category}/products/{product}', function ($category, $product) {
    return "Danh mục: $category, Sản phẩm: $product";
});

//Tham số tùy chon, tham số mặc định
Route::get('/users/{name?}', function ($name = "Guest") {
    return "Xin chào, " . $name;
});

//Tham số có điều kiện
Route::get('/orders/{id}', function ($id) {
    return "Đơn hàng ID: " . $id;
})->where('id', '[0-9]+');

//Đặt tên cho route
Route::get('profileqadadadadasa', function () {
    return "Thông tin người dùng";
})->name('profile');

Route::get('/hello', function () {
    return view('hello');
});

//sử dụng nhóm
// Route::prefix('admin')->group(function () {
//     Route::get('/products', [ProductController::class, 'index']);
// });

//Sử dụng resource
Route::resource('/my-products', MyProductController::class);

//Lấy ra danh sách products
Route::get('/products', [ProductController::class, 'index']);
//Chi tiết sản phẩm
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

//Sản phẩm theo danh mục
Route::get('/category/{id}', [CategoryController::class, 'list'])->name('category.list');


//Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/products', AdminProductController::class);
});
