<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/12
 * Time: 下午2:14
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class HomeAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/reset.css'
    ];

    public $depends =[
        'frontend\assets\AppAsset'
    ];

}