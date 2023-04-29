<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/3/3 13:05
 */

namespace App\Modules\Resources\Repository;

use App\Models\Resources;

/**
 * Notes: 资源表SQL
 *
 * Class ResourcesRepository
 * @package App\Modules\Resources\Repository
 */
class ResourcesRepository
{
    /**
     * Notes: 根据文件路径查找
     * User: admin
     * Date: 2020/3/3 17:24
     *
     * @param $path
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null|Resources
     */
    public function findByPath($path)
    {
        return Resources::where('path', $path)->first();
    }

    /**
     * Notes: 根据id查找
     * User: admin
     * Date: 2020/3/4 13:25
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null|Resources
     */
    public function findById($id)
    {
        return Resources::where('id', $id)->first();
    }

    /**
     * Notes: 获取所有资源列表
     * User: admin
     * Date: 2020/3/4 14:30
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        $id = request()['id'];
        $model_type = request()['model_type'];
        $model_id = request()['model_id'];
        $name = request()['name'];
        $path = request()['path'];
        $extension = request()['extension'];
        $md5 = request()['md5'];
        $size = request()['size'];

        $select = Resources::select();
        //筛选id
        if ($id) {
            $select->where('id', $id);
        }
        //筛选模型类型
        if ($model_type) {
            $select->where('model_type', $model_type);
        }
        //筛选名字
        if ($model_id) {
            $select->where('name', $name);
        }
        //筛选路径
        if ($path) {
            $select->where('path', $path);
        }
        //筛选拓展名
        if ($extension) {
            $select->where('extension', $extension);
        }
        //筛选md5
        if ($md5) {
            $select->where('md5', $md5);
        }
        //筛选大于的大小
        if ($size) {
            $select->where('size', '<', $size);
        }

        return $select->paginate(request()['limit']);
    }

    /**
     * Notes: 查找资源依赖
     * User: admin
     * Date: 2020/3/4 14:43
     *
     * @param $id
     * @return Resources|\Illuminate\Database\Eloquent\Model|mixed|null
     */
    public function findDepend($id)
    {
        $resources = $this->findById($id);
        if ($resources) {
            return $resources;
        }

        return null;
    }
}
