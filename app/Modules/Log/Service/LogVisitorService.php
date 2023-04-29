<?php


namespace App\Modules\Log\Service;

use App\Models\LogVisitor;
use App\Modules\Log\Entity\LogVisitorVO;
use App\Modules\Log\Repository\LogVisitorRepository;
use Illuminate\Http\Request;

/**
 * Notes: 访客日志记录服务
 *
 * Class VisitorLogService
 * @package App\Modules\Log\Service
 */
class LogVisitorService
{
    private $repository;

    /**
     * Notes: 是否开启写入日志
     *
     * @var bool
     */
    private $isWriteLog = true;

    public function __construct(LogVisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Notes: 写入访客记录
     * User: admin
     * Date: 2021/04/30 00:33
     *
     * @param LogVisitorVO $visitorVO
     * @param $query
     * @return bool
     */
    public function writeLog(LogVisitorVO $visitorVO, $query)
    {
        try {
            $logVisitor = $visitorVO->getTableObject();

            $logVisitor->save();

            return true;
//          先不记录这个，数据太多了
//            if ($logVisitor->save()) {
//                //写入SQL执行记录
//                if (count($query) > 0) {
//                    $items = [];
//                    foreach ($query as $value) {
//                        $item = [];
//                        $item['log_visitor_id'] = $logVisitor->id;
//                        $item['connection'] = $value['connection'];
//                        $item['query'] = $value['query'];
//                        $item['time'] = $value['time'];
//                        $item['created_at'] = $logVisitor->fromDateTime(time());
//                        $item['updated_at'] = $logVisitor->fromDateTime(time());
//                        array_push($items, $item);
//                    }
//                    //使用insert减少SQL调用次数
//                    $logVisitor->logSql()->insert($items);
//                }
//
//                return true;
//            }

        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Notes: 可以搜索查询访客记录
     * User: admin
     * Date: 2021/04/30 00:33
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listLogVisitor(Request $request)
    {
        return $this->repository->listLogVisitor($request);
    }

    /**
     * Notes: 查找访客记录
     * User: admin
     * Date: 2021/04/30 00:33
     *
     * @param $id
     * @return LogVisitor|LogVisitor[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findLogVisitor($request)
    {
        return $this->repository->findLogVisitor($request);
    }

    /**
     * Notes: 我的登录日志
     * User: admin
     * Date: 2021/04/30 00:33
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function meLogVisitor($request)
    {
        return $this->repository->meLogVisitor($request);
    }

    /**
     * Notes: 查询SQL记录
     * User: admin
     * Date: 2021/04/30 00:33
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listLogSql(Request $request)
    {
        return $this->repository->listLogSql($request);
    }

    /**
     * Notes: 查找SQL记录
     * User: admin
     * Date: 2021/04/30 00:33
     *
     * @param $id
     * @return \App\Models\LogSql|\App\Models\LogSql[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findLogSql($id)
    {
        return $this->repository->findLogSql($id);
    }
}
