<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Query builder
        // $products = DB::table('products')
        //     ->join('categories', 'categories.id', '=', 'products.category_id')
        //     ->select(['products.*', 'categories.name as cate_name'])
        //     ->orderBy('id', 'desc')
        //     ->paginate(10);

        //Eloquent ORM
        //Lấy ra toàn bộ dữ liệu
        $products = Product::all();

        //Lấy dữ liệu có phân trang và sắp xếp
        $products = Product::with('category')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = DB::table('categories')->get();

        //Eloquent ORM
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductController $request)
    {
        // $data = $request->except('_token'); //Sử cho Query builder

        $data = $request->all();

        //xử lý file
        if ($request->hasFile('image')) {
            $path_image = $request->file('image')->store('images');
        }

        $data['image'] = $path_image ?? null;

        // DB::table('products')->insert($data);

        $product = Product::query()->create($data);

        return redirect()
            ->route('admin.products.edit', $product->id)
            ->with('message', 'Thêm dữ liệu thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact('product', 'categories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('image');

        //Xử lý ảnh
        if ($request->hasFile('image')) {
            $path_image = $request->file('image')->store('images');
            $data['image'] = $path_image;
        }

        //Cập nhật
        Product::find($id)->update($data);

        return redirect()->back()->with('message', 'Cập nhật dữ liệu thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // DB::table('products')->delete($id);

        $product = Product::find($id);

        //Xóa ảnh
        if (Storage::fileExists($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('message', 'Xóa dữ liệu thành công');
    }
}
