<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/11 13:36
 */

namespace App\Modules\Common\Traits;

use App\Models\SaveDeleteRecord;
use App\Modules\Common\Entity\DataOperateTable;
use App\Modules\Common\Enum\DataOperateEnum;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Venturecraft\Revisionable\Revisionable;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Notes: 模型创建和删除记录
 *
 * Trait SaveDeleteRecordTraits
 * @package App\Modules\Common\Traits
 */
trait SaveDeleteRecordTrait
{
    /**
     * 模型数据变动记录
     */
    use RevisionableTrait, QueryCacheable;
    /**
     * Notes: 多态关联key
     *
     * @var string
     */
    public static $recordKey = 'records';
    /**
     * Notes: 数据变动记录key
     *
     * @var string
     */
    public static $revisionHistoryKey = 'revisionHistory';

    /**
     * Notes: 多态关联 save_delete_record表
     * User: admin
     * Date: 2020/1/11 14:37
     *
     * @return mixed
     */
    public function records()
    {
        return $this->morphMany(SaveDeleteRecord::class, 'recordable');
    }

    /**
     * Notes: 获取操作记录
     * User: admin
     * Date: 2020/2/21 12:36
     *
     * @return array
     */
    public function getRecords()
    {
        //创建记录
        $records = $this->records;
        //更改记录
        $revisionHistory = $this->revisionHistory;

        return (new DataOperateTable($records, $revisionHistory))->get();
    }

    /**
     * Notes: 获取创建记录
     * User: admin
     * Date: 2020/2/14 18:35
     *
     * @return mixed|\Illuminate\Database\Eloquent\Builder
     */
    public static function withCreateRecord()
    {
        return static::with([
            self::$recordKey => function($query) {
                $query->where('operate', DataOperateEnum::CREATE);
            }
        ]);
    }

    /**
     * Notes: 启动
     * User: admin
     * Date: 2020/1/11 14:38
     *
     */
    public static function boot()
    {
        parent::boot();

        static::bootRecordTraits();
    }

    /**
     * Notes: 启动监听
     * User: admin
     * Date: 2020/1/11 14:38
     *
     */
    public static function bootRecordTraits()
    {
        static::created(function ($model) {
            $model->recordCreate();
        });

        static::deleting(function ($model) {
            $model->recordDelete();
        });
    }

    /**
     * Notes: 记录创建
     * User: admin
     * Date: 2020/1/11 15:13
     *
     */
    public function recordCreate()
    {
        $this->record(DataOperateEnum::CREATE);
    }

    /**
     * Notes: 记录删除
     * User: admin
     * Date: 2020/1/11 15:13
     *
     */
    public function recordDelete()
    {
        $this->record(DataOperateEnum::DELETE);
    }

    /**
     * Notes: 保存
     * User: admin
     * Date: 2020/1/11 15:13
     *
     * @param $operate
     */
    private function record($operate)
    {
        $model = new SaveDeleteRecord();
        $model->recordable_type = $this->getMorphClass();
        $model->recordable_id = $this->getKey();
        $model->user_id = $this->getSystemUserId()??-1;
        $model->operate = $operate;
        $model->username = my_username()??'system';
        $model->name = my_name()??'system';
        $model->record = $this->toJson();

        $model->save();
    }

    /**
     * Notes: 主动保存数据变动记录
     * User: admin
     * Date: 2020/5/19 11:40
     *
     * @param $key
     * @param $oldValue
     * @param $newValue
     * @return bool
     */
    public function saveChange($key, $oldValue, $newValue)
    {
        $revisions = array(
            'revisionable_type' => $this->getMorphClass(),
            'revisionable_id' => $this->getKey(),
            'key' => $key,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'user_id' => $this->getSystemUserId(),
            'created_at' => now(),
            'updated_at' => now(),
        );

        $revision = Revisionable::newModel();

        return \DB::table($revision->getTable())->insert($revisions);
    }
}
