<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Modules\User\Enum\UserTypesEnum;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * 路由权限访问检测
 * Class RouterPermission
 * @package App\Http\Middleware
 */
class CheckPermission
{
    /**
     * Notes: 需要忽略权限检测的路由列表
     *
     * @var array
     */
    private $ignoreRoute = [
        'auth.login',
        'auth.info',
        'auth.logout',
        'auth.test',
        'translation.languages',
        'captcha.create',
        'init.initSuperAdmin',
        'init.initDefaultRole',
        'log.writeLogWithBody',
        'user.createAccount',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        $name = app('router')->getRoutes()->match($request)->getName();
        /**
         * 不在忽略权限检测列表，而且不是超级管理员的用户都需要检测路由访问的权限
         */
        if (!in_array($name, $this->ignoreRoute)) {
            if (!is_super_admin()) {
                $user = User::find(api_user()['id']);
                if ($user) {
//                    if (!$user->checkRouterPermission($name)) {
//                        /**
//                         * 无权限
//                         */
//                        throw new AuthorizationException;
//                    }

                } else {
                    /**
                     * 未登录
                     */
                    throw new UnauthorizedHttpException('jwt-auth', 'Unauthorized');
                }
            }
        }

        return $next($request);
    }
}
