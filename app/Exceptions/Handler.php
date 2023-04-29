<?php

namespace App\Exceptions;

use App\Common\ExceptionReport;
use App\Modules\Log\Service\LogExceptionService;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Notes: 异常日志服务
     *
     * @var LogExceptionService
     */
    private $service;

    public function __construct(Container $container, LogExceptionService $service)
    {
        parent::__construct($container);

        $this->service = $service;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Notes: Render an exception into an HTTP response.
     * User: admin
     * Date: 2020/2/29 15:45
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, \Throwable $exception)
    {
        $this->service->writeLog($exception);

        // 将方法拦截到自己的ExceptionReport
        $reporter = ExceptionReport::make($exception);
        if ($reporter->shouldReturn()) {
            return $reporter->report();
        }

        if(env('APP_DEBUG')) {
            //开发环境，则显示详细错误信息
            return parent::render($request, $exception);
        } else {
            //线上环境,未知错误，则显示500
            return $reporter->prodReport();
        }
    }
}
