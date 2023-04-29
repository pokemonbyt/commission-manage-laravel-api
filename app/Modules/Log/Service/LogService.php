<?php


namespace App\Modules\Log\Service;

use App\Models\Log;
use App\Models\User;
use App\Modules\Log\Enum\LogInOutEnum;
use App\Modules\Log\Enum\LogTypeEnum;
use App\Modules\Log\Repository\LogRepository;

/**
 * Notes: Log业务
 *
 * Class LogService
 * @package App\Modules\Log\Service
 */
class LogService
{
    private $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * Notes: 插入客户APPLog记录
     * User: admin
     * Date: 2021/05/05 20:59
     *
     * @return bool
     * @throws \Exception
     */
    public function writeClientLog()
    {
        // 1:登录 2：登出
        $type = request()['type'];
        $typeName = '';
        if ($type == LogInOutEnum::LOG_IN) {
            $typeName = 'log_in';
        } else if ($type == LogInOutEnum::LOG_OUT) {
            $typeName = 'log_out';
        }
        $body = [
            'type' => $typeName,
            'device_id' => request()['device_id'],
            'local_ip' => request()['local_ip'],
            'public_ip' => request()['public_ip']
        ];
        //插入
        $this->writeLogData(LogTypeEnum::CLIENT_VISITOR, 0, 0, $body);
        //清空超过数量的记录
        if ($type == LogInOutEnum::LOG_OUT) {
            $count = Log::all()->count();
            //如果记录的数量超过 200000，清空最老的 50000记录。
            if ($count > 200000) {
                $top = Log::orderByDesc('id')->first()->id;
                $temp = $top - 50000;
                Log::where('id', '<', $temp)->delete();
            }
        }
        return true;
    }

    /**
     * Notes: 手动写Log(自定义内容)
     * User: admin
     * Date: 2022/03/01 14:45
     *
     * @param $type
     * @param $body
     * @return bool
     */
    public function writeLogWithBody($type, $body)
    {
        if (my_user_id()) {
            $this->writeLogData($type, User::class, my_user_id(), $body, my_name());
        }
        return true;
    }

    /**
     * Notes: 插入用户Log记录
     * User: admin
     * Date: 2021/05/06 15:03
     *
     * @param $userName
     * @param $visitorType
     */
    public function writeUserVisitorLog($userName, $visitorType)
    {
        $browser = \Agent::browser();
        $version = \Agent::version($browser);
        $ip = utils()->getRealIp();
        $browerStr = "$browser($version)";

        $typeName = '';
        $userId = User::where('username', $userName)->first()->id;
        if ($visitorType == LogInOutEnum::LOG_IN) {
            $typeName = 'log_in';
        } else if ($visitorType == LogInOutEnum::LOG_OUT) {
            $typeName = 'log_out';
        }
        //插入
        $body = [
            'type' => $typeName,
            'username' => $userName,
            'browser' => $browerStr,
            'ip' => $ip
        ];
        $this->writeLogData(LogTypeEnum::ADMIN_VISITOR, User::class, $userId, $body);
    }

    /**
     * Notes: 获取客户APP LOG
     * User: admin
     * Date: 2021/05/08 14:07
     *
     * @return mixed
     */
    public function getClientLog()
    {
        return $this->logRepository->getClientLog();
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
        return $this->logRepository->getUserVisitorLog($request);
    }

    /**
     * Notes: 获取我登录-登出Log
     * User: admin
     * Date: 2021/07/17 10:32
     *
     * @return mixed
     */
    public function getMeVisitorLog($request)
    {
        return $this->logRepository->meLogVisitor($request);
    }

    /**
     * Notes: 保存记录
     * User: admin
     * Date: 2022/03/01 14:32
     *
     * @param $type
     * @param $modelType
     * @param $modelId
     * @param $body
     * @param string $remark
     */
    private function writeLogData($type, $modelType, $modelId, $body, $remark = null)
    {
        $log = new Log();
        $log->type =$type;
        $log->model_type = $modelType;
        $log->model_id = $modelId;
        if ($type != LogTypeEnum::CLIENT_VISITOR && $type != LogTypeEnum::ADMIN_VISITOR) {
            $log->body = json_decode($body);
        } else {
            $log->body = $body;
        }
        $log->remark = $remark;
        $log->save();
    }

}
