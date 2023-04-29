<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/29 21:57
 */

namespace App\Modules\User\ErrorCode;


class UserErrorCode
{
    //用户不存在
    const USER_DOES_NOT_EXIST = -1000201;
    //工号已经存在
    const DUPLICATE_USERNAME = -1000202;
    //艺名已经存在
    const DUPLICATE_NAME = -1000203;
    //用户创建服务器异常
    const USER_CREATE_EXCEPTION = -1000204;
    //验证安全密码失败
    const PRIVACY_PASSWORD_CHECK_FAIL = -1000205;
    //验证成功验证成功
    const PRIVACY_PASSWORD_CHECK_PASS = -1000206;
    //验证成功验证失败
    const PRIVACY_PASSWORD_UPDATE_FAIL = -1000207;
    //验证成功验证成功
    const PRIVACY_PASSWORD_UPDATE_PASS = -1000208;
    //验证密码失败
    const LOGIN_PASSWORD_CHECK_FAIL = -1000209;
    //密码旧新一样错误
    const PASSWORD_BE_SAME_ERROR = -1000210;
    //不允许修改10000的Type
    const CANNOT_CHANGE_SUPER_ADMIN_TYPE = -1000211;
    //绑定roles异常
    const ASSIGN_ROLE_EXCEPTION = -1000212;
    //不能删除超级管理员
    const CANNOT_DELETE_SUPER_ADMIN = -1000213;
    //chi co the tao user thap hon minh
    const CANNOT_CREATE_HIGHER_USER = -1000214;

    //Loai nguoi dung nay khong duoc tao du lieu
    const USER_CANNOT_CREATE_DATA = -1000215;

    //Loai nguoi dung nay khong duoc tao du lieu
    const NOT_PERMISSION_FOR_THIS_USER = -1000216;

    //Trung lap agency
    const AGENCY_DUPLICATE = -1000217;

    private static $text = [
        self::USER_DOES_NOT_EXIST => 'Người dùng không tồn tại.',
        self::DUPLICATE_USERNAME => 'Trùng lặp username.',
        self::DUPLICATE_NAME => 'Trùng lặp name.',
        self::USER_CREATE_EXCEPTION => 'Tạo user gặp bất thường.',
        self::PRIVACY_PASSWORD_CHECK_FAIL => 'privacy password check fail.',
        self::PRIVACY_PASSWORD_CHECK_PASS => 'privacy password check passed.',
        self::PRIVACY_PASSWORD_UPDATE_FAIL => 'privacy password update fail.',
        self::PRIVACY_PASSWORD_UPDATE_PASS => 'privacy password update passed.',
        self::LOGIN_PASSWORD_CHECK_FAIL => 'Mật khẩu không đúng.',
        self::PASSWORD_BE_SAME_ERROR => 'Mật khẩu cũ không được giống mật khẩu mới.',
        self::CANNOT_CHANGE_SUPER_ADMIN_TYPE => 'cannot change type of super admin.',
        self::ASSIGN_ROLE_EXCEPTION => 'assign role exception.',
        self::CANNOT_DELETE_SUPER_ADMIN => 'Không thể xóa Superadmin.',
        self::CANNOT_CREATE_HIGHER_USER => 'Không thể tạo user cấp cao hơn.',
        self::USER_CANNOT_CREATE_DATA => 'Người dùng này không được phép tạo dữ liệu.',
        self::NOT_PERMISSION_FOR_THIS_USER => 'Người dùng này không thuộc quyền quản lý của bạn.',
        self::AGENCY_DUPLICATE => 'Trùng lặp đại lý.',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
