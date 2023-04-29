<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/3 12:59
 */

namespace App\Modules\Resources\Service;

use App\Modules\Resources\ErrorCode\ResourcesErrorCode;
use App\Modules\Resources\Repository\ResourcesRepository;
use App\Modules\Resources\Traits\ResourcesUpload;
use App\Modules\User\ErrorCode\UserErrorCode;
use App\Modules\User\Repository\UserRepository;

/**
 * Notes: 资源上传业务
 *
 * Class ResourcesService
 * @package App\Modules\Resources\Service
 */
class ResourcesService
{
    use ResourcesUpload;

    private $repository;

    private $userRepository;

    public function __construct(ResourcesRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * Notes: 上传文件
     * User: admin
     * Date: 2020/3/4 12:44
     *
     * @return array|int
     */
    public function upload()
    {
        return $this->uploadFile();
    }

    /**
     * Notes: 批量上传文件
     * User: admin
     * Date: 2020/3/4 12:44
     *
     * @return array|int
     */
    public function uploads()
    {
        return $this->uploadFiles();
    }

    /**
     * Notes: 上传用户头像
     * User: admin
     * Date: 2020/3/4 12:53
     *
     * @param $userId
     * @return bool|int
     */
    public function uploadAvatar($userId)
    {
        $user = $this->userRepository->findById($userId);
        if ($user) {
            if ($user->resources->count() > 0) {
                foreach ($user->resources as $item) {
                    $item->delete();
                }
            }

            return $user->uploadFiles();
        }

        return UserErrorCode::USER_DOES_NOT_EXIST;
    }

    /**
     * Notes: 删除资源
     * User: admin
     * Date: 2020/3/4 13:26
     *
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $resources = $this->repository->findById($id);
        if ($resources) {
            if ($resources->model) {
                return ResourcesErrorCode::FILE_HAVE_LINK;
            }

            \Storage::delete($resources->path);
            $resources->delete();

            return true;
        }

        return ResourcesErrorCode::FILE_DOES_NOT_EXIST;
    }

    /**
     * Notes: 下载文件，使用路径或者资源id都可以下载
     * User: admin
     * Date: 2020/3/3 17:27
     *
     * @param $path
     * @param $id
     * @return int|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($path, $id)
    {
        $resources = null;

        if ($path) {
            $resources = $this->repository->findByPath($path);
        } else {
            if ($id) {
                $resources = $this->repository->findById($id);
            }
        }

        if ($resources) {
            return \Storage::download($resources->path, $resources->name);
        }

        return false;
    }

    /**
     * Notes: 获取所有资源列表
     * User: admin
     * Date: 2020/3/4 14:31
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Notes: 查找资源依赖
     * User: admin
     * Date: 2020/3/4 14:44
     *
     * @param $id
     * @return \App\Models\Resources|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function findDepend($id)
    {
        return $this->repository->findDepend($id);
    }
}
