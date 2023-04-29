<?php


namespace App\Modules\Log\Repository;

use App\Models\LogSql;
use App\Models\LogVisitor;
use Illuminate\Http\Request;

/**
 * Notes: 访客日志记录SQL语句
 *
 * Class VisitorLogRepository
 * @package App\Modules\Log\Repository
 */
class LogVisitorRepository
{
    private $logVisitor;
    private $logSql;

    public function __construct(LogVisitor $logVisitor, LogSql $logSql)
    {
        $this->logVisitor = $logVisitor;
        $this->logSql = $logSql;
    }

    /**
     * Notes: 可以搜索查询访客记录
     * User: admin
     * Date: 2021/04/30 13:37
     *
     * @param Request $request
     * @return mixed
     */
    public function listLogVisitor(Request $request)
    {
        $select = LogVisitor::select();
        //工号名字
        if ($request->name) {
            $select->whereRaw("concat(username,name) like '%{$request->name}%'");
        }
        //浏览器
        if ($request->browser) {
            $select->where('browser', 'like', '%'.$request->browser.'%');
        }
        //IP
        if ($request->ip) {
            $select->where('ip', $request->ip);
        }
        //路由
        if ($request->router) {
            $select->where('router', 'like', '%'.$request->router.'%');
        }
        //路由名称
        if ($request->router_name) {
            $select->where('router_name', 'like', '%'.$request->router_name.'%');
        }

        if ($request->from_time && $request->to_time) {
            $select->where('created_at', '>=', $request->from_time)->where('created_at', '<=', $request->to_time);
        }

        $select->orderBy('id', 'desc');

        return $select->paginate($request->limit);
    }

    /**
     * Notes: 查找我的访问日志
     * User: admin
     * Date: 2021/07/17 15:55
     *
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function meLogVisitor($request)
    {
        $select = LogVisitor::select();

        $select->where('username', my_username());
//        $select->whereNotNull('username');

        //浏览器
        if ($request->browser) {
            $select->where('browser', 'like', '%'.$request->browser.'%');
        }
        //IP
        if ($request->ip) {
            $select->where('ip', $request->ip);
        }
        //路由
        if ($request->router) {
            $select->where('router', 'like', '%'.$request->router.'%');
        }
        //路由名称
        if ($request->router_name) {
            $select->where('router_name', 'like', '%'.$request->router_name.'%');
        }

        if ($request->from_time && $request->to_time) {
            $select->where('created_at', '>=', $request->from_time)->where('created_at', '<=', $request->to_time);
        }

        $select->orderBy('id', 'desc');

        return $select->paginate($request->limit);
    }

    /**
     * Notes: 查找访客记录
     * User: admin
     * Date: 2021/04/30 13:37
     *
     * @param $id
     * @return mixed
     */
    public function findLogVisitor($id)
    {
        return LogVisitor::find($id);
    }

    /**
     * Notes: 查询SQL全部记录
     * User: admin
     * Date: 2021/04/30 13:38
     *
     * @param Request $request
     * @return mixed
     */
    public function listLogSql(Request $request)
    {
        return LogSql::select()->orderBy('id', 'desc')->paginate($request->limit);
    }

    /**
     * Notes: 查找SQL记录
     * User: admin
     * Date: 2021/04/30 13:38
     *
     * @param $id
     * @return mixed
     */
    public function findLogSql($id)
    {
        return LogSql::where('log_visitor_id', $id)->get();
    }


}
