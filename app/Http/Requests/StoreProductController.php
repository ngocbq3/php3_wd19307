<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductController extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'description' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.max' => 'Tên sản phẩm không được lớn hơn 255 ký tự',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'stock.required' => 'Số lượng sản phẩm không được để trống',
            'stock.integer' => 'Số lượng sản phẩm phải là số nguyên',
            'image.image' => 'File tải lên phải là ảnh',
            'image.mimes' => 'File tải lên phải có định dạng jpeg,png,jpg,gif,svg',
            'image.max' => 'Kích thước file tải lên không được lớn hơn 2MB',
        ];
    }
}
