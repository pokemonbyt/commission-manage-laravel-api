<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 00:32
 */

namespace App\Modules\Log\Entity;

use App\Models\LogVisitor;
use Illuminate\Foundation\Auth\User;
use Illuminate\Queue\SerializesModels;

/**
 * Notes: 访客对象数据对象
 *
 * Class LogVisitorVO
 * @package App\Modules\Log\Entity
 */
class LogVisitorVO
{
    private $username;
    private $name;
    private $ip;
    private $router;
    private $router_name;
    private $browser;
    private $request;
    private $response;
    private $time;

    /**
     * Notes: 获取访客记录表对象
     * User: admin
     * Date: 2021/04/30 00:32
     *
     * @param LogVisitor|null $visitor
     * @return LogVisitor|null
     */
    public function getTableObject(LogVisitor $visitor = null)
    {
        if (!$visitor) {
            $visitor = new LogVisitor();
        }

        $visitor->username = $this->getUsername();
        $visitor->name = $this->getName();
        $visitor->ip = $this->getIp();
        $visitor->router = $this->getRouter();
        $visitor->router_name = $this->getRouterName();
        $visitor->browser = $this->getBrowser();
        $visitor->request = $this->getRequest();
        $visitor->response = null;//$this->getResponse(); 数据太多，先去掉
        $visitor->time = $this->getTime();

        return $visitor;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param mixed $router
     */
    public function setRouter($router): void
    {
        $this->router = $router;
    }

    /**
     * @return mixed
     */
    public function getRouterName()
    {
        return $this->router_name;
    }

    /**
     * @param mixed $router_name
     */
    public function setRouterName($router_name): void
    {
        $this->router_name = $router_name;
    }

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param mixed $browser
     */
    public function setBrowser($browser): void
    {
        $this->browser = $browser;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request): void
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }
}
