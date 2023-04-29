<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use App\Modules\Common\Traits\SaveDeleteRecordTrait;
use App\Modules\ExternalSystem\Config\PromotionSystemActionEnum;
use App\Modules\ExternalSystem\Service\CloudDiskService;
use App\Modules\ExternalSystem\Service\OldOAService;
use App\Modules\ExternalSystem\Service\PromotionSystemService;
use App\Modules\Permission\Traits\HasRouter;
use App\Modules\Resources\Traits\ResourcesUpload;
use App\Modules\User\Enum\UserTypesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Venturecraft\Revisionable\Revision;


/**
 * App\Models\User
 *
 * @property int $id id
 * @property int $pid pid
 * @property string $username 员工工号
 * @property string $name 员工艺名
 * @property string $password 密码
 * @property int $types 账号类型
 * @property mixed $privacy_password 安全密码
 * @property string|null $phone 手机号码
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Revision[] $history
 * @property-read int|null $history_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaveDeleteRecord[] $records
 * @property-read int|null $records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Resources[] $resources
 * @property-read int|null $resources_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User types()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePrivacyPassword($value)
 * @method static Builder|User whereTypes($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRouter, SaveDeleteRecordTrait, ResourcesUpload, ModelToolTrait;

    protected $table = 'users';

    /**
     * 是否开启数据记录
     *
     * @var bool
     */
    protected $revisionEnabled = true;

    /**
     * 绑定资源上传
     * @var bool
     */
    protected $isBindResModel = true;

    /**
     * 权限需要的默认守卫
     *
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'privacy_password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Notes: 密码非对称加密
     * User: admin
     * Date: 2021/06/02 13:00
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Notes: 安全密码对称加密
     * User: admin
     * Date: 2021/06/02 13:00
     *
     * @param $value
     */
    public function setPrivacyPasswordAttribute($value)
    {
        $this->attributes['privacy_password'] = encrypt($value);
    }

    /**
     * Notes: 解密安全密码
     * User: admin
     * Date: 2021/06/02 13:00
     *
     * @param $value
     * @return mixed
     */
    public function getPrivacyPasswordAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * 获取JWT标识
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 返回一个键值数组，包含要添加到JWT的所有自定义声明。
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Notes: 监听数据变动
     * User: admin
     * Date: 2021/06/02 13:01
     *
     */
    protected static function booted()
    {

    }

    /**
     * Notes: 添加局部过滤器
     * User: admin
     * Date: 2021/06/02 13:01
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeTypes(Builder $query)
    {
        return $query->where('types', UserTypesEnum::USER);
    }

    //根据艺名查找用户物件
    public static function userByUsername($username){
        return self::where('username',$username)->first();
    }
}
