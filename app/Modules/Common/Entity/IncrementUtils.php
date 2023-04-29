<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/8/31 13:00
 */

namespace App\Modules\Common\Entity;

/**
 * Notes: 生成自增id的工具
 *
 * Class IncrementUtils
 * @package App\Modules\Common\Entity
 */
class IncrementUtils
{
    /**
     * 单据的编号key
     */
    const PROCESS_NUMBER = "process:number";

    /**
     * 仓库-固定资产的编号key
     */
    const FIXED_NUMBER = "fixed:number";

    /**
     * 需要每天重置的自增id可以在这里配置
     * @var string[]
     */
    public static $resetKey = [
        self::PROCESS_NUMBER,
        self::FIXED_NUMBER
    ];

    /**
     * Notes: 获取自增id
     * User: admin
     * Date: 2020/8/31 13:02
     *
     * @param $key
     * @return mixed
     */
    public static function getId($key)
    {
        \Cache::increment($key);

        return \Cache::get($key);
    }

    /**
     * Notes: 获取日期类的自增id
     * User: admin
     * Date: 2020/8/31 13:13
     *
     * @param $key
     * @param int $len
     * @return string
     */
    public static function getDateId($key, $len = 5)
    {
        $date = date('Ymd');
        $id = self::getId($key);

        $id = str_pad($id, $len,"0",STR_PAD_LEFT);

        return "{$date}{$id}";
    }

    /**
     * Notes: 获取固定资产的自增id
     * User: admin
     * Date: 2021/03/14 15:29
     *
     * @param $key
     * @param int $len
     * @return string
     */
    public static function getFixedId($key, $len = 5)
    {
        $date = date('Ymd');
        $id = self::getId($key);

        $id = str_pad($id, $len,"0",STR_PAD_LEFT);

        return "{$date}-{$id}";
    }

    /**
     * Notes: 删除id
     * User: admin
     * Date: 2020/8/31 13:18
     *
     * @param $key
     * @return bool
     */
    public static function delId($key)
    {
        return \Cache::forget($key);
    }

    /**
     * Notes: 每日0点重置当然的自增id
     * User: admin
     * Date: 2020/8/31 16:07
     *
     */
    public static function resetId()
    {
        foreach (self::$resetKey as $key) {
            self::delId($key);
        }
    }
}
