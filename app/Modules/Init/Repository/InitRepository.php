<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 15:06
 */

namespace App\Modules\Init\Repository;

use App\Models\InitRecord;

/**
 * Notes: SQL
 *
 * Class InitRepository
 * @package App\Modules\Init\Repository
 */
class InitRepository
{
    /**
     * Notes: 根据类型查找
     * User: admin
     * Date: 2021/04/30 15:09
     *
     * @param $type
     * @return mixed
     */
    public function findByType($type)
    {
        return InitRecord::where('type', $type)->first();
    }
}
