<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Post extends Model
{
    use HasFactory, Prunable;

    /**
     * The table associated with the model. (Bảng kết hợp với mô hình.)
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable. (Các thuộc tính có thể gán hàng loạt.)
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'like',
        'dislike',
        'view',
        'active'
    ];

    // Mỗi khi chạy lệnh php artisan model:prune --model="App\Models\Post".
    // Nó sẽ vào bảng posts tìm kiếm tất cả các record có field active là 0 và xóa trong database đi
    public function prunable()
    {
        return $this->where('active', 0);
    }
}
