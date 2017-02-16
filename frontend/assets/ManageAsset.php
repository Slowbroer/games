<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/16
 * Time: 上午10:40
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ManageAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css =[
        'css/manage.css'
    ];

    public $depends = [
        'frontend\assets\AppAsset'
    ];
}