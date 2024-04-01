<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            // REVIEW: security
            // Nếu người dùng truyền nên 1 mảng dữ liệu thì hệ thống có xử lý được không?
            // Hãy thêm các rule khác để chắc chắn rằng ứng dụng sẽ nhận được các dữ liệu mong muốn
            // Tham khảo: 'title' => 'required|string|min:3|max:255'
            // - Bắt buộc có dữ liệu
            // - Phải là 1 chuỗi ký tự
            // - Có tối thiểu 3 ký tự
            // - Có nhiều nhất 255 ký tự
            'title' => 'required',
            'description' => 'required'
        ];
    }
}
