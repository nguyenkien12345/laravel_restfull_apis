<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

Route::get('/', function () {
    return view('welcome');
});

// Start Create Links that will Expire in Laravel - Signed Route
Route::get('share/videos/{video}', function(Request $request, $video){
    // Để vào đường dẫn này yêu cầu phải có signature hash
    // Phải định nghĩa name cho route thì mới có thể sử dụng Signed routes để sinh ra signature hash
    // Cách 1: Kiểm tra trong route
    // if(!$request->hasValidSignature()){
    //     abort(401);
    // }

    // Cách 2: Sử dụng middleware
    return 'https://www.youtube.com/watch?v=4t5CZsyomGE&video=' . $video;
})->name('share-video')->middleware('signed');

// Trả ra URL với phương thức bảo vệ là Signed routes (Sẽ sinh ra 1 URL kèm theo một signature hash) => có thể hạn chế được các request giả mạo lên server
Route::get('/playground', function (){
    // Nhận vào 3 tham số:
    // 1) name của route mà ta muốn tham chiếu đến để đính kèm signature hash
    // 2) expire time của route
    // 3) Nếu route đó có params thì ra sẽ truyền thêm tham số params, không có thì không truyền (Không bắt buộc)
    $url = URL::temporarySignedRoute('share-video', now()->addSeconds(30), ['video' => 123456]);
    // Tham chiếu đến name share-video sau đó sinh ra signature hash với thời gian tồn tại là 30s với parameter video là 123456
    return $url;
});
// End Create Links that will Expire in Laravel - Signed Route
