<?php


namespace App\Modules\Log\Service;


use App\Models\LogException;
use App\Modules\Log\Repository\LogExceptionRepository;
use Exception;
use Illuminate\Http\Request;

class LogExceptionService
{
    private $repository;

    /**
     * Notes: 是否开启写入日志
     *
     * @var bool
     */
    private $isWriteLog = false;

    public function __construct(LogExceptionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Notes: 写入异常日志
     * User: admin
     * Date: 2021/04/30 00:34
     *
     * @param \Throwable $exception
     * @return false
     */
    public function writeLog(\Throwable $exception)
    {
        if (!is_api_route()) {
            return false;
        }

        if (!$this->isWriteLog) {
            return false;
        }

        try {
            $browser = \Agent::browser();
            $version = \Agent::version($browser);
            $route = app('router')->getRoutes()->match(\request());

            $ex = [
                "message" => $exception->getMessage(),
                "exception" => get_class($exception),
                "file" => $exception->getFile(),
                "line" => $exception->getLine(),
                "trace" => $exception->getTrace()
            ];

            $logException = new LogException();
            $logException->ip = utils()->getRealIp();
            $logException->router = \request()->getPathInfo();
            $logException->router_name = $route->getName();
            $logException->username = api_auth()->user()['username'];
            $logException->name = api_auth()->user()['name'];

            if ($browser) {
                $logException->browser = "$browser($version)";
            }

            $logException->request = json_encode(\request()->all(), JSON_UNESCAPED_UNICODE);
            $logException->exception = json_encode($ex, JSON_UNESCAPED_UNICODE);

            return $logException->save();

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Notes: 可以搜索查询异常记录
     * User: admin
     * Date: 2021/04/30 00:34
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listException(Request $request)
    {
        return $this->repository->listException($request);
    }
}
