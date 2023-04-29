<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/29 20:59
 */

namespace App\Modules\User\Service;

use App\Modules\User\Enum\UserTypesEnum;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Notes: 用户密码业务
 *
 * Class UserPasswordService
 * @package App\Modules\User\Service
 */
class UserPasswordService
{
    protected $defPassword = "123123";

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Notes: 登录密码修改
     * User: admin
     * Date: 2021/04/29 23:45
     *
     * @param $key
     * @param $captcha
     * @param $oldPassword
     * @param $newPassword
     * @return int
     */
    public function updatePassword($oldPassword, $newPassword)
    {
        $user = api_user_model();

        if (!(Hash::check($oldPassword, $user->password))) {
            return UserErrorCode::LOGIN_PASSWORD_CHECK_FAIL;
        }

        if(strcmp($oldPassword, $newPassword) == 0){
            return UserErrorCode::PASSWORD_BE_SAME_ERROR;
        }

        $user->password = $newPassword;

        return $user->save();
    }

    /**
     * Notes: 更新别人的密码
     * User: admin
     * Date: 2021/06/08 15:19
     *

     * @param $newPassword
     * @param $username
     * @return int
     */
    public function updateUserPassword($newPassword, $username)
    {
        $user = $this->userRepository->findByUserName($username);
        if (!$user) {
            return UserErrorCode::USER_DOES_NOT_EXIST;
        }

        $user->password = $newPassword;

        return $user->save();
    }

    /**
     * Notes: 重置登录密码
     * User: admin
     * Date: 2021/04/29 23:46
     *
     * @param $username
     * @return false|int
     */
    public function resetPassword($username)
    {
        $user = $this->userRepository->findByUserName($username);
        $myUser = $this->userRepository->findById(my_user_id());
        if($user) {
            //不能修改超级管理员的登录密码，除了登陆人是超级管理员
            if ($user->types == UserTypesEnum::SUPER_ADMIN) {
                if ($myUser->types != UserTypesEnum::SUPER_ADMIN) {
                    return false;
                }
            }

            $user->password = $this->defPassword;

            return $user->save();
        }

        return UserErrorCode::USER_DOES_NOT_EXIST;
    }

    /**
     * Notes: 检查登录密码是否为默认123456
     * User: admin
     * Date: 2021/04/29 23:46
     *
     * @return false
     */
    public function checkDefaultPassword()
    {
        $user = api_user_model();
        if ($user) {
            return Hash::check($this->defPassword, $user->password);
        }

        return false;
    }

    /**
     * Notes: 检查安全密码是否为默认123456
     * User: admin
     * Date: 2021/04/29 23:46
     *
     * @return bool
     */
    public function checkDefaultPrivacyPassword()
    {
        $user = api_user_model();
        if ($user) {
            return $this->defPassword == $user->privacy_password;
        }

        return false;
    }

    /**
     * Notes: 设置安全密码
     * User: admin
     * Date: 2021/04/29 23:47
     *
     * @param $key
     * @param $captcha
     * @param $password
     * @return false|int
     */
    public function createPrivacyPassword($key, $captcha, $password)
    {
        $user = api_user_model();
        if ($user) {
            if($user->privacy_password == null) {
                $user->privacy_password = $password;
                return $user->save();
            }

            return UserErrorCode::PRIVACY_PASSWORD_UPDATE_FAIL;
        }

        return false;
    }

    /**
     * Notes: 修改安全密码
     * User: admin
     * Date: 2021/04/29 23:47
     *
     * @param $key
     * @param $captcha
     * @param $oldPassword
     * @param $newPassword
     * @return false|int
     */
    public function updatePrivacyPassword($key, $captcha, $oldPassword, $newPassword)
    {
        $user = api_user_model();
        if ($user) {
            if($oldPassword != $user->privacy_password) {
                return UserErrorCode::PRIVACY_PASSWORD_CHECK_FAIL;
            }

            if(strcmp($oldPassword, $newPassword) == 0){
                return UserErrorCode::PASSWORD_BE_SAME_ERROR;
            }

            $user->privacy_password = $newPassword;

            return $user->save();
        }

        return false;
    }

    /**
     * Notes: 验证安全密码
     * User: admin
     * Date: 2021/04/29 23:47
     *
     * @param $password
     * @return bool|int
     */
    public function verifyPrivacyPassword($password)
    {
        $user = api_user_model();
        if ($user) {
            if($password != $user->privacy_password) {
                return UserErrorCode::PRIVACY_PASSWORD_CHECK_FAIL;

            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Notes: 是否已经验证安全密码
     * User: admin
     * Date: 2021/04/29 23:47
     *
     * @return mixed
     */
    public function isVerifyPrivacyPassword()
    {
        return true;
    }

    /**
     * Notes: 重置安全密码
     * User: admin
     * Date: 2021/04/29 23:47
     *
     * @param $username
     * @return false|int
     */
    public function resetPrivacyPassword($username)
    {
        $user = $this->userRepository->findByUserName($username);
        if($user) {
            //不能修改超级管理员的安全密码
            if ($user->types == UserTypesEnum::SUPER_ADMIN) {
                return false;
            }

            $user->privacy_password = $this->defPassword;

            return $user->save();
        }

        return UserErrorCode::USER_DOES_NOT_EXIST;
    }
}
