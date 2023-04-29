<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2021/04/30 12:06
 */

namespace App\Http\Controllers\Api\Init;


use App\Http\Controllers\Controller;
use App\Modules\Init\Service\InitService;
use Illuminate\Http\Request;

class InitController extends Controller
{
    /**
     * @var InitService
     */
    private $service;

    public function __construct(InitService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 初始化超级管理员
     * User: admin
     * Date: 2021/04/30 15:04
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function initSuperAdmin(Request $request)
    {
        return $this->success($this->service->initSuperAdmin());
    }

}
