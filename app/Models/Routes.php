<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:20
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Routes
 *
 * @property int $id id
 * @property string $name 名字
 * @property string $url 路由路径
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PermissionHasRoutes[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Routes whereUrl($value)
 * @mixin \Eloquent
 */
class Routes extends Model
{
    use ModelToolTrait;

    protected $table = 'routes';

    /**
     * Notes: 和权限的对应关系
     * User: admin
     * Date: 2019/12/28 11:58
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(PermissionHasRoutes::class, 'router_id');
    }
}
