<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission;

/**
 * App\Models\Menus
 *
 * @property int $id id
 * @property string|null $name 组件名字
 * @property string $path 路由路径
 * @property string|null $component 组件
 * @property string|null $redirect 重定向路径
 * @property string $title 标题
 * @property string|null $icon 图标
 * @property int $hidden 是否在侧边栏隐藏
 * @property int $no_cache 是否被缓存
 * @property int $outreach 是否可以跳转外部连接
 * @property int $sort 排序
 * @property int $pid 父级id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereComponent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereNoCache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereOutreach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menus extends Model
{
    use ModelToolTrait;

    protected $table = 'menus';

    protected $hidden = [
        'updated_at',
    ];

    /**
     * Notes: 属性修改器(可以转换字段返回)
     *
     * @var array
     */
    protected $casts = [
        'hidden' => 'boolean',
        'outreach' => 'boolean',
        'no_cache' => 'boolean',
    ];

    /**
     * Notes: 反向关联权限表 （多对多）
     * User: admin
     * Date: 2020/1/3 14:41
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class,
            'permission_has_menus',
            'menu_id',
            'permission_id');
    }
}
