<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\ErrorCode\AuthErrorCode;
use App\Modules\Auth\Request\LoginRequest;
use App\Modules\Auth\Resource\AuthResource;
use App\Modules\Auth\Service\AuthService;
use App\Modules\Log\Enum\LogInOutEnum;
use App\Modules\Log\Service\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Notes: 认证控制器
 *
 * Class AuthController
 * @package App\Http\Controllers\Api\Auth
 */
class AuthController extends Controller
{
    private $service;
    private $logService;

    public function __construct(AuthService $service, LogService $logService)
    {
        $this->service = $service;
        $this->logService = $logService;
    }

    /**
     * Notes: 登录
     * User: admin
     * Date: 2021/04/29 16:49
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $result = $this->service->login();
        if ($result === AuthErrorCode::VERIFY_FAILED ||
            $result === AuthErrorCode::NOT_LOGIN ||
            $result === AuthErrorCode::VERIFICATION_CODE_ERROR) {
            return $this->failed($result, AuthErrorCode::getText($result));

        } else if (is_array($result)) {

            return $this->success($result);

        } else {
            //Log
            $this->logService->writeUserVisitorLog(request()->get('username'), LogInOutEnum::LOG_IN);
            return $this->success('bearer ' . $result);
        }
    }

    public function refreshInfoAfterDelete()
    {
        $leave = User::where('is_active', 0)->get();
        $i = Carbon::today()->format('md');
        foreach ($leave as $item)
        {
            $item->username = $item->username.'删除'.$i;
            $item->name = $item->name.'删除'.$i;
            $item->save();
        }
    }

    /**
     * Notes: 登出
     * User: admin
     * Date: 2021/04/29 16:49
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        return $this->success($this->service->logout());
    }

    /**
     * Notes: 获取当前登录的用户信息
     * User: admin
     * Date: 2021/04/29 16:50
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        return $this->success(new AuthResource($this->service->getInfo()));
    }

}
