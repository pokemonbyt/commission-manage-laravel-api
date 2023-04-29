<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Log
 *
 * @property int $id
 * @property int $type Log类型
 * @property string $model_type 模型类型
 * @property int $model_id 模型id
 * @property int|null $user_id 用户id
 * @property string|null $body 内容Json
 * @property string|null $remark 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 * @mixin \Eloquent
 */
class Log extends Model
{
    use ModelToolTrait;

    protected $table = 'log';

    /**
     * Notes: 转换body为json
     * User: admin
     * Date: 2021/05/05 21:09
     *
     * @param $value
     */
    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = json_encode($value);
    }

    /**
     * Notes: 转换body为数组
     * User: admin
     * Date: 2021/05/05 21:10
     *
     * @param $value
     * @return mixed
     */
    public function getBodyAttribute($value)
    {
        return json_decode($value, true);
    }
}
