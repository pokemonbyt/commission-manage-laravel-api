<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionHasMenus
 *
 * @property int $menu_id 菜单id
 * @property int $permission_id 权限id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasMenus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasMenus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasMenus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasMenus whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionHasMenus wherePermissionId($value)
 * @mixin \Eloquent
 */
class PermissionHasMenus extends Model
{
    use ModelToolTrait;

    protected $table = 'permission_has_menus';

    public $timestamps = false;
}
