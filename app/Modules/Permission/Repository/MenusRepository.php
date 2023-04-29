<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/1 17:34
 */

namespace App\Modules\Permission\Repository;

use App\Models\Menus;
use App\Modules\Permission\Entity\MenuVO;

/**
 * Notes: 菜单表SQL操作
 *
 * Class MenusRepository
 * @package App\Modules\Permission\Repository
 */
class MenusRepository
{
    /**
     * Notes: 创建菜单
     * User: admin
     * Date: 2020/1/1 19:57
     *
     * @param MenuVO $menu
     * @return bool
     */
    public function create(MenuVO $menu)
    {
        return $this->save(new Menus(), $menu);
    }

    /**
     * Notes: 删除菜单
     * User: admin
     * Date: 2020/1/2 12:27
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return Menus::destroy($id);
    }

    /**
     * Notes: 编辑菜单
     * User: admin
     * Date: 2020/1/2 14:42
     *
     * @param MenuVO $menu
     * @return bool
     */
    public function edit(MenuVO $menu)
    {
        $menus = $this->findByTitle($menu->getTitle());
        if ($menus) {
           return $this->save($menus, $menu);
        }

        return false;
    }

    /**
     * Notes: 保存菜单
     * User: admin
     * Date: 2020/1/2 14:42
     *
     * @param Menus $menus
     * @param MenuVO $menu
     * @return bool
     */
    public function save(Menus $menus, MenuVO $menu)
    {
        $menus->name = $menu->getName();
        $menus->path = $menu->getPath();
        $menus->component = $menu->getComponent();
        $menus->redirect = $menu->getRedirect();
        $menus->title = $menu->getTitle();
        $menus->icon = $menu->getIcon();
        $menus->hidden = $menu->getHidden();
        $menus->no_cache = $menu->getNoCache();
        $menus->outreach = $menu->getOutreach();
        $menus->sort = $menu->getSort();
        $menus->pid = $menu->getPid();

        return $menus->save();
    }

    /**
     * Notes: 全部菜单
     * User: admin
     * Date: 2020/1/2 12:34
     *
     * @return Menus[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Menus::all()->sortBy('sort');
    }

    /**
     * Notes: 根据title查找菜单
     * User: admin
     * Date: 2020/1/1 19:54
     *
     * @param $title
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findByTitle($title)
    {
        return Menus::where('title', $title)->first();
    }

    /**
     * Notes: 根据name查找菜单
     * User: admin
     * Date: 2020/1/10 11:06
     *
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findByName($name)
    {
        return Menus::where('name', $name)->first();
    }

    /**
     * Notes: 根据id查找菜单
     * User: admin
     * Date: 2020/1/2 12:25
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findById($id)
    {
        return Menus::where('id', $id)->first();
    }

    /**
     * Notes: 根据id列表查找菜单
     * User: admin
     * Date: 2020/1/3 11:08
     *
     * @param array $ids
     * @return \Illuminate\Support\Collection
     */
    public function listById(array $ids)
    {
        return Menus::whereIn('id', $ids)->get();
    }
}
