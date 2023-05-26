<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use app\assets\AppAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SortableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';

    
    public $js = [
    	'js/sortableui/jquery-ui.js',
        'js/sortableui/jquery-ui.min.js',
        
    ];
    public $css = [
        'js/sortableui/jquery-ui.css',
        'js/sortableui/jquery-ui.min.css',
        'js/sortableui/jquery-ui.structure.css',
        'js/sortableui/jquery-ui.structure.min.css',
        'js/sortableui/jquery-ui.theme.css',
        'js/sortableui/jquery-ui.theme.min.css',
    ];

}
