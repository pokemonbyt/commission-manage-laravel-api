<?php


namespace App\Modules\Log\Repository;

use App\Models\LogException;
use Illuminate\Http\Request;

/**
 * Notes: 异常日志SQL语句
 *
 * Class LogErrorRepository
 * @package App\Modules\Log\Repository
 */
class LogExceptionRepository
{
    private $logError;

    public function __construct(LogException $logError)
    {
        $this->logError = $logError;
    }

    /**
     * Notes: 可以搜索查询异常记录
     * User: admin
     * Date: 2021/04/30 13:37
     *
     * @param Request $request
     * @return mixed
     */
    public function listException(Request $request)
    {
        $select = LogException::select();
        //工号名字
        if ($request->name) {
            $select->whereRaw("concat(username,name) like '%{$request->name}%'");
        }
        //浏览器
        if ($request->browser) {
            $select->where('browser', 'like', $request->browser);
        }
        //IP
        if ($request->ip) {
            $select->where('ip', $request->ip);
        }
        //路由
        if ($request->router) {
            $select->where('router', 'like', $request->router);
        }
        //路由名称
        if ($request->router_name) {
            $select->where('router_name', 'like', $request->router_name);
        }

        $select->orderBy('id', 'desc');

        return $select->paginate($request->limit);
    }
}
