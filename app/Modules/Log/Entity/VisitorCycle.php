<?php


namespace App\Modules\Log\Entity;

use App\Modules\Common\Enum\QueueLevelEnum;
use App\Modules\Log\Service\LogVisitorService;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher as Event;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Notes: 一个请求生命周期监听
 *
 * Class VisitorCycle
 * @package App\Modules\Log\Entity
 */
class VisitorCycle
{
    /**
     * Notes: 查询记录器
     *
     * @var QueriesCollection
     */
    private $queriesCollection;
    /**
     * Notes: 是否队列处理
     *
     * @var bool
     */
    private $isQueue = true;
    /**
     * Notes: 访客服务
     *
     * @var LogVisitorService
     */
    private $service;

    /**
     * Notes: 需要忽略写入请求参数和返回数据的路由
     *
     * @var array
     */
    private $ignoreRouter = [
        'auth.login',
        'log.listLogVisitor',
        'log.listLogSql',
        'log.listException',
    ];

    public function __construct(Event $event, QueriesCollection $queriesCollection, LogVisitorService $service)
    {
        $this->queriesCollection = $queriesCollection;
        $this->service = $service;

        $event->listen(RequestHandled::class, function (RequestHandled $handled) {
            $this->writeLog($handled->request, $handled->response);
        });
    }

    /**
     * Notes: 写入日志
     * User: admin
     * Date: 2021/04/30 13:39
     *
     * @param Request $request
     * @param Response $response
     * @return false
     */
    public function writeLog(Request $request, Response $response)
    {
        if (is_api_route()) {
            $json = json_decode($response->getContent(), true);
            if (empty($json['code'])) {
                return false;
            }

            if ($json['code'] > 0 && $json['code'] != 200) {
                return false;
            }

            //浏览器记录
            $browser = \Agent::browser();
            $version = \Agent::version($browser);

            $visitorVO = new LogVisitorVO();
            $visitorVO->setUsername(api_auth()->user()['username']);
            $visitorVO->setName(api_auth()->user()['name']);
            $visitorVO->setIp(utils()->getRealIp());
            $visitorVO->setRouter(\request()->getPathInfo());
            $visitorVO->setRouterName(app('router')->getRoutes()->match($request)->getName());
            $visitorVO->setTime(0);

            if ($browser) {
                $visitorVO->setBrowser("$browser($version)");
            }

            if (!in_array($visitorVO->getRouterName(), $this->ignoreRouter)) {
                $visitorVO->setRequest(json_encode(\request()->all(), JSON_UNESCAPED_UNICODE));
                $visitorVO->setResponse($response->getContent());
            }

//            if ($this->isQueue) {
//                //队列写入
//                LogVisitorJob::dispatch($visitorVO, $this->queriesCollection->getQueries())->onQueue(QueueLevelEnum::LOW);
//
//            } else {
                //同步写入
                $this->service->writeLog($visitorVO, $this->queriesCollection->getQueries());
//            }

            //清理SQL缓存
            $this->queriesCollection->clear();
        }
    }
}
