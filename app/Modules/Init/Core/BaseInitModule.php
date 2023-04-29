<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 14:20
 */

namespace App\Modules\Init\Core;


use App\Models\InitRecord;
use App\Modules\Common\Enum\SwitchEnum;
use App\Modules\Init\Config\InitModuleConfig;
use App\Modules\Init\Entity\InitRecordVO;
use App\Modules\Init\Repository\InitRepository;

/**
 * Notes: 初始化模块基类
 *
 * Class BaseInitModule
 * @package App\Modules\Init\Core
 */
abstract class BaseInitModule
{
    /**
     * @var InitRepository
     */
    protected $repository;
    /**
     * @var int
     */
    protected $type;

    private $result;

    public function __construct($type)
    {
        $this->repository = app(InitRepository::class);
        $this->type = $type;

        $initRecord = $this->repository->findByType($type);
        if ($initRecord && $this->isInit($initRecord)) {
            $this->result = "模块已经被初始化过了";
            return;
        }

        $this->start();
    }

    /**
     * Notes: 结果
     * User: admin
     * Date: 2021/04/30 15:07
     *
     * @return string
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * @param $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

    /**
     * Notes: 模块是否已经初始化
     * User: admin
     * Date: 2021/04/30 15:07
     *
     * @param InitRecord $initRecord
     * @return bool
     */
    protected function isInit(InitRecord $initRecord)
    {
        return $initRecord->is_init == SwitchEnum::YES;
    }

    /**
     * Notes: 保存初始化数据
     * User: admin
     * Date: 2021/04/30 15:08
     *
     * @param $data
     * @return mixed
     */
    protected function saveRecord($data)
    {
        $initRecordVO = new InitRecordVO();
        $initRecordVO->setType($this->type);
        $initRecordVO->setIsInit(SwitchEnum::YES);
        $initRecordVO->setRemark(InitModuleConfig::getText($this->type));
        $initRecordVO->setRecord(serialize($data));

        return $initRecordVO->getTableObject()->save();
    }

    /**
     * Notes: 运行逻辑
     * User: admin
     * Date: 2021/04/30 15:08
     *
     * @return mixed
     */
    abstract function start();
}
