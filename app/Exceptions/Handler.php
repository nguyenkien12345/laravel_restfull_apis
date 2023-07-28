<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    // Thuộc tính này chứa một mảng các kiểu exception sẽ không cần log
    // Xem trong class cha của class Handler ta sẽ thấy 1 mảng các Exception đã được thêm vào sẵn ở thuộc tính $internalDontReport
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    // Nó sẽ chứa 1 mảng các input sẽ không bao giờ được truyền đi nếu có exception validate
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    // Phương thức report được sử dụng để log các exception hoặc gửi chúng tới các dịch vụ ngoài như Bugsnag hoặc Sentry
    // Mặc định, phương thức report đơn giản chỉ đấy các exception về class nơi mà exception được log lại. Tuy nhiên, chúng ta có thể hoàn toàn tùy biến theo ý mình muốn.
    // Nếu bạn cần report nhiều kiểu exception theo nhiều cách khác nhau, bạn có thể sử dụng toán tử kiểm tra của PHP instanceof, ví dụ:
    // public function report(Exception $exception){
    //     if($exception instanceof UserException) {
    //         // Do Some Thing Like:
    //         // \Log::debug('User Not Found');
    //     }
    //     parent::report($exception);
    // }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // Phương thức render có tránh nhiệm chuyển đổi một exception thành một HTTP response để trả lại cho trình duyệt
    public function render($request, Throwable $exception)
    {
        // Với những trường hợp dùng hàm findOrFail() thì khi không tìm thấy đối tượng nó sẽ ném ra 1 Eloquent exception có tên là ModelNotFoundException.
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'status' => Response::HTTP_NOT_FOUND,
                'text' => 'failure',
                'message' => $exception->getMessage(),
                'time' => date("d/m/Y h:i:s"),
                'errorCode' =>  'ModelNotFoundException'
            ], Response::HTTP_NOT_FOUND);
        }

        // Với những trường hợp khi ta nhập 1 đường dẫn api không tồn tại thì nó sẽ ném ra 1 Eloquent exception có tên là NotFoundHttpException
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'status' => Response::HTTP_NOT_FOUND,
                'text' => 'failure',
                'message' => 'page not found',
                'time' => date("d/m/Y h:i:s"),
                'errorCode' =>  'ModelNotFoundException'
            ], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }
}
