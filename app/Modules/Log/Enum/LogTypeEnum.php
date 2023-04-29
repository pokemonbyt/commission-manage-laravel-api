<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/05/05 20:55
 */

namespace App\Modules\Log\Enum;


class LogTypeEnum
{
    //客户APP登录-登出
    const CLIENT_VISITOR = 1;
    //激活工具登录-登出
    const ADMIN_VISITOR = 2;
    //网站访问
    const WEBSITE_VISITOR = 3;

    public static $all = [
        self::CLIENT_VISITOR,
        self::ADMIN_VISITOR
    ];

    public static function all(){
        return [
            self::CLIENT_VISITOR,
            self::ADMIN_VISITOR,
            self::WEBSITE_VISITOR
        ];
    }
}
