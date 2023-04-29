<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * App\Models\PermissionOrRoleInfo
 *
 * @property int $id id
 * @property int $model_id 模型id
 * @property int $model_type 模型类型
 * @property string|null $name 名字
 * @property string|null $description 描述
 * @property int $status 是否可以授权状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\Permission\Models\Permission $permission
 * @property-read \Spatie\Permission\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionOrRoleInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermissionOrRoleInfo extends Model
{
    use ModelToolTrait;

    protected $table = 'permission_or_role_info';

    /**
     * Notes: 关联权限（一对一）
     * User: admin
     * Date: 2020/3/27 20:12
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'model_id');
    }

    /**
     * Notes: 关联角色（一对一）
     * User: admin
     * Date: 2020/3/27 20:26
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'model_id');
    }
}
