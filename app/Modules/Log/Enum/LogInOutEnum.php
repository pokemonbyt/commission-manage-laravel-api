<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/05/05 20:55
 */

namespace App\Modules\Log\Enum;


class LogInOutEnum
{
    //登录
    const LOG_IN = 1;
    //登出
    const LOG_OUT = 2;

    public static $all = [
        self::LOG_IN,
        self::LOG_OUT
    ];
}
