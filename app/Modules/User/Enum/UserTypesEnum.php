<?php


namespace App\Modules\User\Enum;

/**
 * Notes: 用户类型
 * 字段： Users表 types
 *
 * Class UserTypesEnum
 * @package App\Modules\User\Enum
 */
class UserTypesEnum
{
    //super_admin
    const SUPER_ADMIN = 99;
    //Thlv
    const THLV = 5;
    //hlv
    const HLV = 4;
    //tt
    const TT = 3;
    //mkt
    const MKT = 2;
    //user
    const USER = 1;

    /**
     * Notes: 获取全部
     * User: admin
     * Date: 2021/05/12 10:18
     *
     * @return int[]
     */
    public static function all()
    {
        return [
            self::SUPER_ADMIN,
            self::THLV,
            self::HLV,
            self::TT,
            self::MKT,
            self::USER
        ];
    }

}
