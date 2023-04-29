<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/26 15:21
 */

namespace App\Models;


use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\PermissionHasRoutes
 *
 * @property int $router_id 路由id
 * @property int $permission_id 权限id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasRoutes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasRoutes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasRoutes query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasRoutes wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasRoutes whereRouterId($value)
 * @mixin \Eloquent
 */
class PermissionHasRoutes extends Model
{
    use ModelToolTrait;

    public $table = 'permission_has_routes';

    public $timestamps = false;
}
