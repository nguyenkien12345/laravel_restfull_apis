# JsonResource và ResourceCollection

[Tài liệu tham khảo](https://viblo.asia/p/tim-hieu-api-resource-trong-laravel-bJzKmRb6Z9N)

### Tạo Resource

-   Đối với JsonResource: `php artisan make:resource NameOfResource`
-   Đối với ResourceCollection: `php artisan make:resource NameOfResourceCollection`
-   `VD: php artisan make:resource ProductResource`
-   `VD: php artisan make:resource ProductCollection`

1. **_JsonResource_**

    - Một lớp resource đại diện cho một model cần được chuyển đổi trong một cấu trúc JSON
    - Mỗi một lớp resource định nghĩa sẵn phương thức toArray trả về một mảng thuộc tính của đối tượng nên được chuyển đổi thành JSON khi gửi phản hổi response
    - Chúng ta có thể truy cập thuộc tính của model thông qua biến $this

    ```php
    Route::get('/product', function () {
        return new ProductResource(Product::find(1));
    });
    ```

2. **_ResourceCollection_**

    - Nếu bạn muốn trả về một collection của resource hoặc một paginate, bạn có thể sử dụng phương thức collection khi tạo một thể hiện resource trong route hoặc controller

    ```php
    Route::get('/products', function () {
        return ProductResource::collection(Product::all());
    });
    ```

---

# Factory trong Laravel

[Tài liệu tham khảo](https://viblo.asia/p/su-dung-factory-trong-laravel-8-07LKXQ8DZV4)

### Tạo Factory

-   php artisan make:factory ItemFactory --model=Item

-   Sau khi tạo Factory cho model Item xong ta sẽ thêm đoạn code sau vào trong file ItemFactory.php (database\factories\ItemFactory.php)

```php
<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text,
        ];
    }
}
```

-   Hàm definition() sẽ thêm dữ liệu mẫu tương ứng với trường title, description vào table items.
-   Cuối cùng hãy tạo và thêm code vào controller bên dưới để tạo 500 dummy records.

```php
<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Item::factory()->count(500)->create();
    }
}
```

-   Có 1 cách khác để tạo ra các dummy record đó chính là tạo trên terminal:
    1. php artisan tinker
    2. App\Models\Post::factory()->count(20)->create()

---

# Những lưu ý trong dự án restfull api

## Xử lý Exception

-   Tất cả các exception đều được xử lý qua app/Exceptions/Handler.php
-   Mặc đinh, Laravel sẽ tự động convert các Exception về dạng HTTP response
-   Với những trường hợp dùng hàm findOrFail() thì khi không tìm thấy đối tượng nó sẽ ném ra 1 Eloquent exception có tên là ModelNotFoundException. Hay khi ta nhập 1 đường dẫn api không tồn tại thì nó sẽ ném ra 1 Eloquent exception có tên là NotFoundHttpException

## Xử lý Response Message Chung

-   Đối với những function dùng chung trong Controller thì ta sẽ khai báo trong App\Http\Controllers.
    `VD: success response trả về có cấu trúc giống nhau`

## Xử lý Response Validation trả về dưới dạng Response Json thay vì HTML

-   Đối với API để trả về response của Form Request Validate dưới dạng response json thay vì html thì ta phải ghi đè phương thức failedValidation
    trong chính file Form Request đó
