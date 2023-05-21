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
class HighchartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';

    
    public $js = [
    	'js/highchart/lib/GraphUp_jquery.js',
        'js/highchart/highcharts.js',
    	'js/highchart/highcharts-more.js',
        'js/highchart/highchart-common.js',
    	'js/highchart/highcharts-3d.js',
    	'js/highchart/lib/jspdf.js',
    	'js/highchart/lib/FileSaver.js',
    	'js/highchart/rgbcolor.js',
    	'js/highchart/lib/canvg.js',
        'js/highchart/modules/stock.js',
        'js/highchart/modules/solid-gauge.js',
    	'js/highchart/modules/data.js',
    	'js/highchart/modules/drilldown.js',    
        'js/highchart/modules/exporting.js',
        'js/highchart/modules/accessibility.js',
        'js/highchart/pattern-fill-v2.js',
    ];

}
