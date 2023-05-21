<?php

namespace app\assets;


use yii\web\AssetBundle;

class SiteMainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';
    public $css = [
      
       
    ];
    public $js = [
        'js/jquery-ui.js',
        'js/bootstrap.min.js',
        
  
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}