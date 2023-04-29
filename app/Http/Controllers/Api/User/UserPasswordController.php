<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Redis\ErrorCode\RedisErrorCode;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Service\UserPasswordService;
use Illuminate\Http\Request;

/**
 * Notes: 用户密码控制器
 *
 * Class UserPasswordController
 * @package App\Http\Controllers\Api\User
 */
class UserPasswordController extends Controller
{
    private $service;

    public function __construct(UserPasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 登录密码修改
     * User: admin
     * Date: 2021/04/29 23:58
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        $result = $this->service->updatePassword($request->old_password, $request->new_password);

        if ($result === UserErrorCode::LOGIN_PASSWORD_CHECK_FAIL ||
            $result === UserErrorCode::PASSWORD_BE_SAME_ERROR) {
            return $this->failed($result, UserErrorCode::getText($result));
        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 更新指定用户的密码
     * User: admin
     * Date: 2021/06/08 13:13
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateUserPassword(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'new_password' => 'required',
        ]);

        $result = $this->service->updateUserPassword($request->new_password, $request->username);

        if ($result === UserErrorCode::LOGIN_PASSWORD_CHECK_FAIL ||
            $result === UserErrorCode::USER_DOES_NOT_EXIST ||
            $result === UserErrorCode::PASSWORD_BE_SAME_ERROR) {
            return $this->failed($result, UserErrorCode::getText($result));
        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 重置登录密码
     * User: admin
     * Date: 2021/04/29 23:58
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:' . User::tableName() . ',username',
        ]);

        $result = $this->service->resetPassword($request->username);

        if ($result === UserErrorCode::USER_DOES_NOT_EXIST) {
            return $this->failed($result, UserErrorCode::getText($result));
        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 检查登入密码是否为默认123456
     * User: admin
     * Date: 2021/04/29 23:58
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDefaultPassword(Request $request)
    {
        return $this->success($this->service->checkDefaultPassword());
    }

    /**
     * Notes: 检查安全密码是否为默认123456
     * User: admin
     * Date: 2021/04/29 23:58
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDefaultPrivacyPassword(Request $request)
    {
        return $this->success($this->service->checkDefaultPrivacyPassword());
    }

    /**
     * Notes: 验证安全密码
     * User: admin
     * Date: 2021/04/29 23:59
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPrivacyPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|max:16',
        ]);

        $result = $this->service->verifyPrivacyPassword($request->password);
        if ($result === UserErrorCode::PRIVACY_PASSWORD_CHECK_FAIL) {
            return $this->failed($result, UserErrorCode::getText($result));
        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 是否已经验证安全密码
     * User: admin
     * Date: 2021/04/29 23:59
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function isVerifyPrivacyPassword()
    {
        return $this->success($this->service->isVerifyPrivacyPassword());
    }

    /**
     * Notes: 重置安全密码
     * User: admin
     * Date: 2021/04/29 23:59
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPrivacyPassword(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:' . User::tableName() . ',username',
        ]);


        $result = $this->service->resetPrivacyPassword($request->username);

        if ($result === UserErrorCode::USER_DOES_NOT_EXIST) {
            return $this->failed($result, UserErrorCode::getText($result));
        } else {
            return $this->success($result);
        }
    }
}
