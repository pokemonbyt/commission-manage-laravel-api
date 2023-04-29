<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\AgencyDetails;
use App\Models\AgencyManager;
use App\Models\User;
use App\Modules\User\Entity\UserVO;
use App\Modules\User\Enum\UserTypesEnum;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Service\UserService;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Notes: 用户控制器
 *
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class UserController extends Controller
{
    private $service;

    private $userRoleService;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 创建基本的账户信息
     * User: admin
     * Date: 2021/04/29 23:56
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createAccount(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'name' => 'required',
            'types' => ['required', Rule::in(UserTypesEnum::all())],
        ]);

        $user = new UserVO();
        $user->setRequest($request);
        $result = $this->service->createAccount($user);
        if ($result === UserErrorCode::USER_CREATE_EXCEPTION ||
            $result === UserErrorCode::DUPLICATE_USERNAME ||
            $result === UserErrorCode::ASSIGN_ROLE_EXCEPTION ||
            $result === UserErrorCode::CANNOT_CREATE_HIGHER_USER ||
            $result === UserErrorCode::DUPLICATE_NAME) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 获取登录用户信息
     * User: admin
     * Date: 2021/04/30 15:45
     *
     */
    public function info()
    {
        $result = $this->service->info();
        return $this->success($result);
    }


    /**
     * Notes: 查找所有用户
     * User: admin
     * Date: 2021/04/29 23:56
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 根据工号或者艺名模糊查找用户
     * User: admin
     * Date: 2021/04/29 23:57
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'value' => 'nullable'
        ]);

        return $this->success($this->service->search($request->value));
    }

    /**
     * Notes: 根据工号或者艺名检测用户是否存在
     * User: admin
     * Date: 2021/04/29 23:57
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkUser(Request $request)
    {
        $this->validate($request, [
            'username' => 'nullable',
            'name' => 'nullable'
        ]);

        return $this->success($this->service->checkUser($request->username, $request->name));
    }

    /**
     * Notes: 删除用户
     * User: admin
     * Date: 2021/05/03 17:40
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'username' => 'required'
        ]);
        $result = $this->service->delete($request->username);
        if ($result === UserErrorCode::USER_DOES_NOT_EXIST ||
            $result === UserErrorCode::CANNOT_DELETE_SUPER_ADMIN) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

   public function createAgencyDetails(Request $request)
   {
       $this->validate($request, [
           'agency' => 'required|exists:' . User::tableName() . ',username',
           'player_username' => 'required|string',
           'full_name' => 'required|string',
           'phone' => 'required|string',
           'total_money' => 'required|integer',
       ]);
       $result = $this->service->createAgencyDetails($request);
       if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA ||
           $result === UserErrorCode::NOT_PERMISSION_FOR_THIS_USER) {
           return $this->failed($result, UserErrorCode::getText($result));

       } else {
           return $this->success($result);
       }
   }

   public function uploadAgencyDetails()
   {

   }

    public function updateAgencyDetails(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:' . AgencyDetails::tableName() . ',id',
            'agency' => 'required|exists:' . User::tableName() . ',username',
            'player_username' => 'required|string',
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'total_money' => 'required|integer',
            'logout_days' => 'required|integer',
        ]);
        $result = $this->service->updateAgencyDetails($request);
        if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA ||
            $result === UserErrorCode::NOT_PERMISSION_FOR_THIS_USER) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    public function deleteAgencyDetails(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:' . AgencyDetails::tableName() . ',id',
        ]);
        $result = $this->service->deleteAgencyDetails($request->id);
        if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA ||
            $result === UserErrorCode::NOT_PERMISSION_FOR_THIS_USER) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    public function getAgencyDetails()
    {
        return $this->success($this->service->getAgencyDetails());
    }

    public function createAgencyManager(Request $request)
    {
        $this->validate($request, [
            'agency' => 'required|exists:' . User::tableName() . ',username',
            'level1' => 'required|int',
            'level2' => 'required|int',
            'level3' => 'required|int',
            'level4' => 'required|int',
        ]);
        $result = $this->service->createAgencyManager($request);
        if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA ||
            $result === UserErrorCode::NOT_PERMISSION_FOR_THIS_USER) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    public function updateAgencyManager(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:' . AgencyManager::tableName() . ',id',
            'level1' => 'required',
            'level2' => 'required',
            'level3' => 'required',
            'level4' => 'required',
        ]);
        $result = $this->service->updateAgencyManager($request);
        if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA ||
            $result === UserErrorCode::NOT_PERMISSION_FOR_THIS_USER) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    public function deleteAgencyManager(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:' . AgencyManager::tableName() . ',id',
        ]);
        $result = $this->service->deleteAgencyManager($request->id);
        if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA ||
            $result === UserErrorCode::NOT_PERMISSION_FOR_THIS_USER) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    public function getAgencyManager()
    {
        return $this->success($this->service->getAgencyManager());
    }

    public function getTotalWinLose()
    {
        return $this->success($this->service->getTotalWinLose());
    }

    public function getTotalCommission()
    {
        return $this->success($this->service->getTotalCommission());
    }

    public function importAgencyDetails()
    {
        $result = $this->service->importAgencyDetails();
        if ($result === UserErrorCode::USER_CANNOT_CREATE_DATA) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }
}
