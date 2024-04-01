<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // REVIEW: database
            // Đây là mô tả task cho nên có thể có nhiều ký tự. Em cân nhắc xem khoảng dữ liệu cho phép của varchar(255) có đủ để lưu không nhé
            $table->string('description');
            // REVIEW: database
            // Không cần thiết phải tạo cột này vì trong $table->timestamps() đã có cột created_at (lưu trữ thời gian tạo bản ghi)
            // Ngoài ra cột updated_at lưu trữ thời gian chỉnh sửa lần cuối. Nếu chưa chỉnh sửa thì giá trị = created_at
            $table->date('create_date')->nullable();
            $table->date('end_date')->nullable();
            // REVIEW: scale application/maintenance
            // Lưu ý về các giá trị ít thay đổi trong ứng dụng(ít thay đổi chứ không phải không bao giờ thay đổi)
            // Trong lập trình có 1 số loại giá trị ít thay đổi. Nó thường gắn liền với nghiệp vụ ứng dụng ví dụ như trường status ở dưới
            // Với những loại dữ liệu như thế này thì từ v8.0 trở về trước dev thường khai báo các hằng số cho các giá trị như thế này để xử lý dữ liệu
            // Còn từ 8.1 trở về đây thì có 1 loại datatype khác là enum. https://www.php.net/manual/en/language.types.enumerations.php
            // Em tìm hiểu và sử dụng enum cho status để cải thiện tính mở rộng của ứng dụng để dễ maintain nhé
            $table->string('status')->default('in progress');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('create_date');
            $table->dropColumn('end_date');
            $table->dropColumn('status');
        });
    }
};
