<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogException
 *
 * @property int $id id
 * @property string|null $username 员工工号
 * @property string|null $name 员工艺名
 * @property string|null $browser 浏览器和版本
 * @property string $ip 登录ip
 * @property string $router 访问路由
 * @property string $router_name 访问路由名字
 * @property mixed|null $request 请求参数
 * @property mixed $exception 异常信息
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereRouter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereRouterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogException whereUsername($value)
 * @mixin \Eloquent
 */
class LogException extends Model
{
    use ModelToolTrait;

    protected $table = 'log_exception';
}
