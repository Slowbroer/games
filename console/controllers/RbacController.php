<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/14
 * Time: 下午3:37
 */

namespace console\controllers;


use yii\console\Controller;
use Yii;

class RbacController extends Controller
{


    //角色：管理员，

    public function actionInit(){
        $auth = Yii::$app->authManager;

        /**************************权限start**************************/

        // 添加 "createAnn" 权限
        $checkAnn = $auth->createPermission('checkAnn');
        $checkAnn->description = '查看公告';
        $auth->add($checkAnn);

        // 添加 "createAnn" 权限
        $createAnn = $auth->createPermission('createAnn');
        $createAnn->description = '新建公告';
        $auth->add($createAnn);

        // 添加 "updateAnn" 权限
        $updateAnn = $auth->createPermission('updateAnn');
        $updateAnn->description = '编辑公告';
        $auth->add($updateAnn);

        //添加 "deleteAnn" 权限
        $deleteAnn = $auth->createPermission('deleteAnn');
        $deleteAnn->description = '删除公告';
        $auth->add($deleteAnn);

        //添加 "createEquip" 权限
        $createEquip = $auth->createPermission('createEquip');
        $createEquip->description = '新建装备';
        $auth->add($createEquip);

        //添加 "deleteEquip" 权限
        $deleteEquip = $auth->createPermission('deleteEquip');
        $deleteEquip->description = '删除装备';
        $auth->add($deleteEquip);

        //添加 "updateEquip" 权限
        $updateEquip = $auth->createPermission('updateEquip');
        $updateEquip->description = '编辑更新装备';
        $auth->add($updateEquip);

        //添加 "checkDaily" 权限
        $checkDaily = $auth->createPermission('checkDaily');
        $checkDaily->description = '查看管理员日志';
        $auth->add($checkDaily);

        //添加 "deleteDaily" 权限
        $deleteDaily = $auth->createPermission('deleteDaily');
        $deleteDaily->description = '删除管理员日志';
        $auth->add($deleteDaily);

        //add the permission to check items
        $checkItem = $auth->createPermission('checkItem');
        $checkItem->description = 'check the items';
        $auth->add($checkItem);

        //add the permission to edit items
        $editItem = $auth->createPermission('editItem');
        $editItem->description = 'edit the items';
        $auth->add($editItem);

        //add the permission to delete items
        $delItem = $auth->createPermission('delItem');
        $delItem->description = 'delete the items';
        $auth->add($delItem);

        //add the permission to check package
        $checkPackage = $auth->createPermission('checkPackage');
        $checkPackage->description = 'check the packages';
        $auth->add($checkPackage);

        //add the permission to delete Packages
        $delPackage = $auth->createPermission('delPackage');
        $delPackage->description = 'delete the package';
        $auth->add($delPackage);

        //add the permission to edit Packages
        $editPackage = $auth->createPermission('editPackage');
        $editPackage->description = 'edit the package';
        $auth->add($editPackage);

        /**************************权限end**************************/


        /******************角色start************************/

        // 添加 "server" 角色 客服人员，拥有查看公告权限
        $server = $auth->createRole('server');
        $auth->add($server);

        $auth->addChild($server, $checkAnn);
        $auth->addChild($server, $checkDaily);


        // 添加 "operator" 角色 运营人员
        $operator = $auth->createRole('operator');
        $auth->add($operator);

        $auth->addChild($operator, $createAnn);
        $auth->addChild($operator, $updateAnn);
        $auth->addChild($operator, $deleteAnn);
        $auth->addChild($operator, $createEquip);
        $auth->addChild($operator, $deleteEquip);
        $auth->addChild($operator, $updateEquip);
        $auth->addChild($operator, $server);

        // 添加 "admin" 管理员
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $deleteDaily);
        $auth->addChild($admin, $server);

        /******************角色end************************/
    }
}