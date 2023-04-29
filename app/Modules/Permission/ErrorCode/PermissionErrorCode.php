<?php


namespace App\Modules\Permission\ErrorCode;

/**
 * Notes: 权限模块错误码[-1000101 & -1000200]
 *
 * Class PermissionErrorCode
 * @package App\Modules\Permission\ErrorCode
 */
class PermissionErrorCode
{
    //权限名重复
    const DUPLICATE_PERMISSIONS = -1000101;
    //权限创建异常
    const PERMISSION_CREATE_EXCEPTION = -1000102;
    //权限删除异常
    const PERMISSION_DELETE_EXCEPTION = -1000103;
    //角色名重复
    const DUPLICATE_ROLE = -1000104;
    //角色创建异常
    const ROLE_CREATE_EXCEPTION = -1000105;
    //角色删除异常
    const ROLE_DELETE_EXCEPTION = -1000106;
    //路由重复添加
    const ROUTE_HAS_BEEN_ADDED = -1000107;
    //路由不存在
    const ROUTE_DOES_NOT_EXIST = -1000108;
    //权限不存在
    const PERMISSION_DOES_NOT_EXIST = -1000109;
    //项目内不存在这个路由
    const ROUTE_NOT_FOUND = -1000110;
    //角色不存在
    const ROLE_DOES_NOT_EXIST = -1000111;
    //无权限给其他人分配角色或者权限
    const NOT_PERMISSION_GIVE = -1000112;
    //菜单重复
    const DUPLICATE_MENU = -1000113;
    //菜单不存在
    const MENU_DOES_NOT_EXIST = -1000114;
    //权限编辑异常
    const PERMISSION_EDIT_EXCEPTION = -1000115;
    //角色编辑异常
    const ROLE_EDIT_EXCEPTION = -1000116;

    private static $text = [
        self::DUPLICATE_PERMISSIONS => 'duplicate permissions.',
        self::PERMISSION_CREATE_EXCEPTION => 'permission creation exception.',
        self::PERMISSION_DELETE_EXCEPTION => 'permission delete exception.',
        self::DUPLICATE_ROLE => 'duplicate role.',
        self::ROLE_CREATE_EXCEPTION => 'role creation exception.',
        self::ROLE_DELETE_EXCEPTION => 'role delete exception.',
        self::ROUTE_HAS_BEEN_ADDED => 'route has been added.',
        self::ROUTE_DOES_NOT_EXIST => 'route does not exist.',
        self::PERMISSION_DOES_NOT_EXIST => 'permission does not exist.',
        self::ROUTE_NOT_FOUND => 'route not found.',
        self::ROLE_DOES_NOT_EXIST => 'role does not exist.',
        self::NOT_PERMISSION_GIVE => 'no permission assignment.',
        self::DUPLICATE_MENU => 'duplicate menu.',
        self::MENU_DOES_NOT_EXIST => 'menu does not exist.',
        self::PERMISSION_EDIT_EXCEPTION => 'permission edit exception.',
        self::ROLE_EDIT_EXCEPTION => 'role edit exception.',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
