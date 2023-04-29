<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/25 14:30
 */

namespace App\Modules\Permission\Enum;

/**
 * Notes: 权限是否可以授权
 * 字段: permission_system_info表 status
 *
 * Class PermissionStatusEnum
 * @package App\Modules\Permission\Enum
 */
class PermissionStatusEnum
{
    //不可以授权
    const NOT_AUTH = 0;
    //可以授权
    const AUTH = 1;
}
