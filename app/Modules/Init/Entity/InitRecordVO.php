<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 15:00
 */

namespace App\Modules\Init\Entity;


use App\Models\InitRecord;
use App\Modules\Common\Traits\ObjToJsonTrait;

class InitRecordVO
{
    use ObjToJsonTrait;

    private $id;
    private $type;
    private $is_init;
    private $remark;
    private $record;

    /**
     * Notes: InitRecord
     * User: admin
     * Date: 2021/04/30 15:09
     *
     * @param InitRecord|null $initRecord
     * @return InitRecord|null
     */
    public function getTableObject(InitRecord $initRecord = null)
    {
        if (!$initRecord) {
            $initRecord = new InitRecord();
        }

        $initRecord->type = $this->getType();
        $initRecord->is_init = $this->getIsInit();
        $initRecord->remark = $this->getRemark();
        $initRecord->record = $this->getRecord();

        return $initRecord;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getIsInit()
    {
        return $this->is_init;
    }

    /**
     * @param mixed $is_init
     */
    public function setIsInit($is_init): void
    {
        $this->is_init = $is_init;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark): void
    {
        $this->remark = $remark;
    }

    /**
     * @return mixed
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param mixed $record
     */
    public function setRecord($record): void
    {
        $this->record = $record;
    }
}
