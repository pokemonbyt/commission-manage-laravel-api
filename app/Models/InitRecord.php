<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 15:27
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InitRecord
 *
 * @property int $id
 * @property int $type 初始化的模块类型
 * @property int $is_init 是否已经初始化
 * @property string $remark 备注
 * @property string $record 记录
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereIsInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InitRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InitRecord extends Model
{
    use ModelToolTrait;

    protected $table = 'init_record';
}
