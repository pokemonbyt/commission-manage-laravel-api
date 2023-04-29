<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/11 13:29
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SaveDeleteRecord
 *
 * @property int $id id
 * @property string $recordable_type 模型类型
 * @property int $recordable_id 模型id
 * @property int $user_id 用户id
 * @property string $operate 操作
 * @property string|null $username 员工工号
 * @property string|null $name 员工艺名
 * @property mixed|null $record 模型整条记录
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SaveDeleteRecord $recordable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereOperate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereRecordableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereRecordableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SaveDeleteRecord whereUsername($value)
 * @mixin \Eloquent
 */
class SaveDeleteRecord extends Model
{
    use ModelToolTrait;

    protected $table = 'save_delete_record';

    /**
     * Notes: 定义一对多（多态关联）
     * User: admin
     * Date: 2020/1/11 13:33
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function recordable()
    {
        return $this->morphTo();
    }
}
