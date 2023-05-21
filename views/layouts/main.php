<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\assets\SiteMainAsset;
use app\assets\HighchartAsset;
use app\widgets\Alert;
use yii\helpers\Html;

AppAsset::register($this);
SiteMainAsset::register($this);
HighchartAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    

</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <div class="row">
        <div class="col-sm-1">
            <img src="/task/images/rcb.png" class="logo_image" style="margin-right: 10px;">
        </div>
        <div class="col-sm-6 align-self-center">RCB Predict Playing X1</div>
    </div>
</header>



    
</header>

<main id="main" class="flex-shrink-0" role="main">
    
    <div class="container content">
       
        <?= $content ?>
    </div>
    <div class="modal fade" id="viewModal_lg" tabindex="-1" aria-labelledby="viewModal_lgLabel" aria-hidden="true" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewModal_lgLabel">View Details</h4><button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
            $(document).ready(function () {
                //$('[title]').tooltip();
                $('body').tooltip({
                    selector: '[title]'
                });
            });

            $(document).on('click', 'a.viewModallgBtn', function (e) {
                e.preventDefault();

                if ($(this).data('title')) {
                    $('#viewModal_lg').find('.modal-title').text($(this).data('title'));
                }
                $('#viewModal_lg').modal('show').find('.modal-body').load($(this).attr('href'));
            });
            
            // modal close
            $(document).on('click', '.btn-close', function (e) {
                $('#viewModal_lg').modal('toggle');
            });
            
      
           

    </script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
