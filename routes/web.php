<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyProductController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('/products', AdminProductController::class);
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });
});

require __DIR__ . '/auth.php';
