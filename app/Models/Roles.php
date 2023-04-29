<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:20
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;


class Roles extends Model
{
    use ModelToolTrait;

    protected $table = 'roles';

}
