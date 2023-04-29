<?php

namespace App\Models;

use App\Modules\Common\Traits\ModelToolTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogSql
 *
 * @property int $id id
 * @property string $log_visitor_id 访客记录表id
 * @property string $connection 数据库类型
 * @property mixed $query sql语句
 * @property string $time 执行耗时
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereConnection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereLogVisitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereQuery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogSql whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LogSql extends Model
{
    use ModelToolTrait;

    protected $table = 'log_sql';
}
