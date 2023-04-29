<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/2 14:56
 */

namespace App\Modules\Common\Entity;

/**
 * Notes: 列表生成树结构的工具
 *
 * Class TreeTool
 * @package App\Modules\Common\Entity
 */
class ListToTreeTool
{
    private $tree = [];

    /**
     * Notes: 数据列表转换成树
     * User: admin
     * Date: 2020/1/2 15:19
     *
     * @param array $data 数据列表
     * @param string $sort 排序字段(如果传入排序字段，结果会自动排序)
     * @param int $rootId 根节点ID
     * @param string $pk 主键名称
     * @param string $pid 父节点名称
     * @param string $childName 子节点名称
     */
    public function __construct($data, $sort = '', $rootId = 0, $pk = 'id', $pid = 'pid', $childName = 'children')
    {
        if (is_array($data)) {
            $referList  = [];
            foreach ($data as $key => & $sorData) {
                $referList[$sorData[$pk]] =& $data[$key];
            }

            foreach ($data as $key => $value) {
                $pId = $value[$pid];
                if ($rootId == $pId) {
                    $this->tree[] =& $data[$key];
                }
                else {
                    if (isset($referList[$pId])) {
                        $pNode               =& $referList[$pId];
                        $pNode[$childName][] =& $data[$key];
                        if (!empty($sort)) {
                            usort($pNode[$childName], function ($v1, $v2) use ($sort) {
                                return $v1[$sort] < $v2[$sort];
                            });
                        }
                    }
                }
            }
        }
    }

    /**
     * Notes: 获取结果
     * User: admin
     * Date: 2020/1/2 15:30
     *
     * @return array
     */
    public function get()
    {
        return $this->tree;
    }
}
