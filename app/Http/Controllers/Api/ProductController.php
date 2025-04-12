<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->orderBy('id', 'desc')
            ->paginate(10);
        return response()->json(
            [
                'success'   => true,
                'data'      => $products,
                'message'   => 'Danh sách sản phẩm',
            ],
            200
        );
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'success'   => false,
                    'message'   => 'Không tìm thấy sản phẩm',
                ],
                404
            );
        }
        return response()->json(
            [
                'success'   => true,
                'data'      => $product,
                'message'   => 'Chi tiết sản phẩm',
            ],
            200
        );
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //Validate the data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success'   => false,
                    'message'   => $validator->errors(),
                ],
                422
            );
        }
        //xử lý file ảnh
        if ($request->hasFile('image')) {
            $path_image = $request->file('image')->store('images');
        }
        $data['image'] = $path_image ?? null;
        // Create a new product
        $product = Product::create($data);
        return response()->json(
            [
                'success'   => true,
                'data'      => $product,
                'message'   => 'Thêm sản phẩm thành công',
            ],
            201
        );
    }

    public function update(Request $request, $id) {
        $data = $request->all();

        //Validate the data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success'   => false,
                    'message'   => $validator->errors(),
                ],
                422
            );
        }
        //Lấy sản phẩm theo ID
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'success'   => false,
                    'message'   => 'Không tìm thấy sản phẩm',
                ],
                404
            );
        }
        //xử lý file ảnh
        if ($request->hasFile('image')) {
            $path_image = $request->file('image')->store('images');
            $data['image'] = $path_image;
        }
        //Xóa ảnh cũ
        if ($product->image && $data['image'] != $product->image) {
            Storage::delete($product->image);
        }
        // Update the product
        $product->update($data);
        return response()->json(
            [
                'success'   => true,
                'data'      => $product,
                'message'   => 'Cập nhật sản phẩm thành công',
            ],
            200
        );
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'success'   => false,
                    'message'   => 'Không tìm thấy sản phẩm',
                ],
                404
            );
        }
        //Xóa ảnh cũ
        if ($product->image) {
            Storage::delete($product->image);
        }
        // Delete the product
        $product->delete();
        return response()->json(
            [
                'success'   => true,
                'message'   => 'Xóa sản phẩm thành công',
            ],
            200
        );
    }
}
