<?php


namespace App\Modules\Auth\ErrorCode;

/**
 * Notes: 认证模块错误码[-1000001 & -1000100]
 *
 * Class AuthErrorCode
 * @package App\Modules\Auth\ErrorCode
 */
class AuthErrorCode
{
    //账号或者密码错误
    const VERIFY_FAILED = -1000001;
    //离职人员不允许登录
    const NOT_LOGIN = -1000002;
    //验证码错误
    const VERIFICATION_CODE_ERROR = -1000003;
    //停薪留职人员不允许登录
    const LEAVE_W_PAY_NOT_ALLOWED_LOGIN = -1000004;

    private static $text = [
        self::VERIFY_FAILED => "Tài khoản hoặc mật khẩu không chính xác",
        self::NOT_LOGIN => 'Tài khoản không tồn tại.',
        self::VERIFICATION_CODE_ERROR => 'Mã capcha sai.',
        self::LEAVE_W_PAY_NOT_ALLOWED_LOGIN => 'Tài khoản này không được phép đăng nhập.',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
