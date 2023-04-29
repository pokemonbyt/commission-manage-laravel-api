<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 14:24
 */

namespace App\Modules\Init\Config;

use App\Modules\Common\Enum\SwitchEnum;
use function Symfony\Component\String\s;

/**
 * Notes: 需要初始化的模块配置
 *
 * Class InitModuleConfig
 * @package App\Modules\Init\Config
 */
class InitModuleConfig
{
    const INIT_SUPER_ADMIN = 1000;


    private static $text = [
        self::INIT_SUPER_ADMIN => '初始化生成超级管理员',
    ];

    /**
     * Notes: 获取说明
     * User: admin
     * Date: 2021/04/30 15:09
     *
     * @param $type
     * @return string
     */
    public static function getText($type)
    {
        return self::$text[$type];
    }
}
