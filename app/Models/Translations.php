<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/2/28 11:46
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use App\Modules\Common\Traits\SaveDeleteRecordTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translations
 *
 * @property int $id
 * @property string $key 键
 * @property string $value 值
 * @property int $language_enum 语言枚举类型
 * @property string $remark 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaveDeleteRecord[] $records
 * @property-read int|null $records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereLanguageEnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Translations whereValue($value)
 * @mixin \Eloquent
 */
class Translations extends Model
{
    use SaveDeleteRecordTrait, ModelToolTrait;

    protected $table = 'translations';

    /**
     * Notes: 关联自己,查同一key的多种值
     * User: admin
     * Date: 2020/3/6 11:50
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(self::class, 'key', 'key');
    }
}
