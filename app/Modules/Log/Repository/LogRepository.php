<?php


namespace App\Modules\Log\Repository;


use App\Models\Log;
use App\Models\LogVisitor;
use App\Modules\Log\Enum\LogTypeEnum;
use Illuminate\Http\Request;

/**
 * Notes: Log表SQL操作
 *
 * Class LogRepository
 * @package App\Modules\Log\Repository
 */
class LogRepository
{
    /**
     * Notes: 获取客户APP LOG
     * User: admin
     * Date: 2021/05/06 16:45
     *
     * @return mixed
     */
    public function getClientLog()
    {
        $deviceId = request()['device_id'];
        $localIp = request()['local_ip'];
        $publicIp = request()['public_ip'];
        $query = Log::where('type', LogTypeEnum::CLIENT_VISITOR);
        if ($deviceId) {
            $query->where('body->device_id', 'like', "$deviceId%");
        }
        if ($localIp) {
            $query->where('body->local_ip', 'like', "$localIp%");
        }
        if ($publicIp) {
            $query->where('body->public_ip', 'like', "$publicIp%");
        }
        return $query->paginate(request()['limit']);
    }

    /**
     * Notes: 获取用户登录-登出Log
     * User: admin
     * Date: 2021/05/08 14:39
     *
     * @return mixed
     */
    public function getUserVisitorLog($request)
    {
        $select = LogVisitor::select();
        $select->whereNotNull('username');

        if ($request->username) {
            $select->where('username', $request->username);
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

        return $select->paginate(request()['limit']);
    }

    /**
     * Notes: 我的登录日志
     * User: admin
     * Date: 2021/04/30 13:37
     *
     * @param Request $request
     * @return mixed
     */
    public function meLogVisitor(Request $request)
    {
        $select = LogVisitor::select();

        $select->where('username', my_username());

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

        return $select->paginate(request()['limit']);
    }
}
