<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogVisitor
 *
 * @property int $id id
 * @property string|null $username 员工工号
 * @property string|null $name 员工艺名
 * @property string|null $browser 浏览器和版本
 * @property string $ip 登录ip
 * @property string $router 访问路由
 * @property string $router_name 访问路由名字
 * @property mixed|null $request 请求参数
 * @property mixed|null $response 返回数据
 * @property string $time 执行耗时
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LogSql[] $logSql
 * @property-read int|null $log_sql_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereRouter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereRouterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogVisitor whereUsername($value)
 * @mixin \Eloquent
 */
class LogVisitor extends Model
{
    use ModelToolTrait;

    protected $table = 'log_visitor';

    /**
     * Notes: 和SQL日志一对多
     * User: admin
     * Date: 2021/04/30 00:31
     *
     * @return mixed
     */
    public function logSql()
    {
        return $this->hasMany(LogSql::class);
    }
}
