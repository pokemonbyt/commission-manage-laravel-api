<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/7/2 12:06
 */

namespace App\Modules\Common\Traits;

/**
 * model的拓展工具
 *
 * Trait ModelToolTrait
 * @package App\Modules\Common\Traits
 */
trait ModelToolTrait
{
    /**
     * Notes: 表名
     * User: admin
     * Date: 2020/7/2 12:07
     *
     * @return mixed
     */
    public static function tableName()
    {
        return (new self())->table;
    }

    /**
     * Notes: 统一 laravel7 的时间序列化格式
     * User: admin
     * Date: 2020/7/2 12:08
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
