<?php

namespace App\Http\Controllers\Api\Log;

use App\Http\Controllers\Controller;
use App\Modules\Log\Enum\LogInOutEnum;
use App\Modules\Log\Enum\LogTypeEnum;
use App\Modules\Log\Service\LogService;
use App\Modules\Log\Service\LogVisitorService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



/**
 * Log控制器
 * Class LogController
 * @package App\Http\Controllers\Api\Log
 */
class LogController extends Controller
{
    private $service;

    private $visitorLogService;

    public function __construct(LogService $service, LogVisitorService $visitorLogService)
    {
        $this->service = $service;

        $this->visitorLogService = $visitorLogService;

    }

    /**
     * Notes: 插入客户端Log记录
     * User: admin
     * Date: 2021/05/05 16:03
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function writeClientLog(Request $request){
        $this->validate($request, [
            'type' => ['required', Rule::in([LogInOutEnum::LOG_IN, LogInOutEnum::LOG_OUT])],
            'body' => 'required'
        ]);

        $result = $this->service->writeClientLog();
        return $this->success($result);
    }

    /**
     * Notes: 手动写入Log表（自定义内容）
     * User: admin
     * Date: 2022/03/01 14:20
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function writeLogWithBody(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', Rule::in(LogTypeEnum::all())],
            'body' => 'required'
        ]);
        $result = $this->service->writeLogWithBody($request->type, $request->body);
        return $this->success($result);
    }

    /**
     * Notes: 获取客户APP log
     * User: admin
     * Date: 2021/05/06 16:33
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClientLog()
    {
        $result = $this->service->getClientLog();
        return $this->success($result);
    }

    /**
     * Notes: 获取用户登录-登出Log
     * User: admin
     * Date: 2021/05/08 14:40
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserVisitorLog(Request $request)
    {
        $result = $this->service->getUserVisitorLog($request);
        return $this->success($result);
    }

    /**
     * Notes: 获取我登录-登出Log
     * User: admin
     * Date: 2021/07/17 10:33
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMeVisitorLog(Request $request)
    {
        $result = $this->service->getMeVisitorLog($request);
        return $this->success($result);
    }

    /**
     * Notes: 可以搜索查询访客记录
     * User: admin
     * Date: 2021/06/10 11:33
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listLogVisitor(Request $request)
    {
        return $this->paginate($this->visitorLogService->listLogVisitor($request));
    }

    /**
     * Notes: 查找访客记录
     * User: admin
     * Date: 2021/06/10 11:33
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findLogVisitor(Request $request)
    {
        return $this->success($this->visitorLogService->findLogVisitor($request));
    }

    /**
     * Notes: 我的登录日志
     * User: admin
     * Date: 2021/06/10 11:33
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function meLogVisitor(Request $request)
    {
        return $this->success($this->visitorLogService->meLogVisitor($request));
    }


}
