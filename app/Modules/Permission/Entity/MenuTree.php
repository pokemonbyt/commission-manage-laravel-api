<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/9 14:35
 */

namespace App\Modules\Permission\Entity;

use App\Modules\Common\Entity\ListToTreeTool;

/**
 * Notes: 菜单树结构
 *
 * Class MenuTree
 * @package App\Modules\Permission\Entity
 */
class MenuTree
{
    private $tree;

    public function __construct($data)
    {
        $this->start($data);
    }

    /**
     * Notes: 转换节点结构
     * User: admin
     * Date: 2020/1/9 14:51
     *
     * @param $data
     */
    private function start($data)
    {
        $newData = [];

        foreach ($data as $key => $value) {
            $item = [];
            $item['id'] = $value['id'];
            $item['pid'] = $value['pid'];
            $item['sort'] = $value['sort'];
            $item['created_at'] = $value['created_at'];

            $item['path'] = $value['path'];
            $item['component'] = $value['component'];
            $item['redirect'] = $value['redirect'];
            $item['name'] = $value['name'];
            $item['hidden'] = $value['hidden'];
            $item['outreach'] = $value['outreach'];

            $item['meta'] = [];
            $item['meta']['title'] = $value['title'];
            $item['meta']['icon'] = $value['icon'];
            $item['meta']['noCache'] = $value['no_cache'];

            $item['checked'] = $value['checked']??false;

            $newData[] = $item;
        }

        $this->tree = (new ListToTreeTool($newData, ''))->get();
    }

    /**
     * Notes: 返回树
     * User: admin
     * Date: 2020/1/9 14:51
     *
     * @return mixed
     */
    public function get()
    {
        return $this->tree;
    }
}
