<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/3 15:39
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use App\Modules\Common\Traits\SaveDeleteRecordTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Resources
 *
 * @property int $id
 * @property string|null $model_type 模型类型
 * @property int|null $model_id 模型id
 * @property string $name 资源名字
 * @property string $path 资源保存的路径
 * @property string $extension 资源拓展名
 * @property string $mine_type mine类型
 * @property string $size 资源大小,单位byte
 * @property string $md5 md5
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Resources|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaveDeleteRecord[] $records
 * @property-read int|null $records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereMd5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereMineType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resources whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Resources extends Model
{
    use SaveDeleteRecordTrait, ModelToolTrait;

    protected $table = 'resources';

    /**
     * Notes: 多态关联
     * User: admin
     * Date: 2020/3/4 11:58
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
