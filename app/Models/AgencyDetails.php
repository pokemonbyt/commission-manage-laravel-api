<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/06/02 17:50
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use App\Modules\Common\Traits\SaveDeleteRecordTrait;
use Illuminate\Database\Eloquent\Model;


class AgencyDetails extends Model
{
    use ModelToolTrait, SaveDeleteRecordTrait;

    protected $table = 'agency_details';

    public function users()
    {
        return $this->hasOne(User::class, 'username', 'agency');
    }
}
