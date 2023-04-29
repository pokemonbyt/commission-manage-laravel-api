<?php


namespace App\Modules\Auth\Service;


use App\Modules\Auth\ErrorCode\AuthErrorCode;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Log\Enum\LogInOutEnum;
use App\Modules\Log\Service\LogService;
use App\Modules\User\Repository\UserRepository;

class AuthService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * 登录错误次数限制
     * @var int
     */
    private $errCountLimit = 1;
    private $logService;

    public function __construct(UserRepository $userRepository, LogService $logService)
    {
        $this->userRepository = $userRepository;
        $this->logService = $logService;
    }

    /**
     * Notes: 登录
     * User: admin
     * Date: 2021/04/29 17:20
     *
     * @return bool[]|int
     */
    public function login()
    {
        $username = request()->get('username');
        \Log::info('登录username：'.$username);
        $user = $this->userRepository->findByUserName($username);
        if ($user) {
            if ($user->is_active == SwitchEnum::NO) {
                return AuthErrorCode::NOT_LOGIN;
            }
        } else {
            return AuthErrorCode::NOT_LOGIN;
        }

        //检测登录
        $token = api_auth()->attempt(request(['username', 'password']));
        if ($token) {
            return $token;

        } else {
            return AuthErrorCode::VERIFY_FAILED;
        }
    }

    /**
     * Notes: 登出
     * User: admin
     * Date: 2021/04/29 17:21
     *
     * @return bool
     */
    public function logout(): bool
    {
        $username = my_username();
        api_auth()->logout();

        //Log
        $this->logService->writeUserVisitorLog($username, LogInOutEnum::LOG_OUT);
        return true;
    }

    /**
     * Notes: 获取当前登录的用户信息
     * User: admin
     * Date: 2021/04/29 17:21
     *
     * @return mixed
     */
    public function getInfo()
    {
        return api_auth()->user();
    }
}
