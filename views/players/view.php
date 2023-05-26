<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

\yii\web\YiiAsset::register($this);
$this->title = 'Chart View of Data';
?>
<div class="players-view">
    <div class="card">
    <div class="row ">
        <div class="col-sm-6">
            <h4>SCORE CHART</h4>
            <div id="chartContainer"></div>        </div>
        <div class='<?php echo empty($dataProvider->getModels()) ?"col-sm-12" :"col-sm-6"?>'>
            <h4>PLAYING X1</h4>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '', // Disable the summary section
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    [
                        'attribute' => 'player_id',
                        'label' => 'Player Name',
                        'value' =>function($model){
                            return $model->player->name;
                        }
                    ],
                    [
                        'attribute' => 'player_id',
                        'label' => 'Jersey NO',
                        'value' =>function($model){
                            return $model->player->jersey_no;
                        }
                    ],
                    [
                        'attribute' => 'player_id',
                        'label' => 'Player Name',
                        'value' =>function($model){
                            return $model->player->name;
                        }
                    ],
                    'score',
                    
                ],
            ]);
            ?>
        </div>
            
    
    </div>

    <div class="btnrow">

        <?= Html::a('Back', ['index'], ['class' => 'btn', 'style'=>'margin-top:50px;']) ?>

    </div>
</div></div>
<?Php
$data = [];
foreach ($dataProvider->getModels() as $player) {
    $data[] = [
        'name' => $player->player->name,
        'y' => $player->score,
    ];
}
if (!empty($dataProvider->getModels())){
    $jsonData = json_encode($data);

    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart data
        var chartData = <?php echo $jsonData; ?>;

        // Extract color and name information from chartData
        var colorData = chartData.map(function (item) {
            return {
                name: item.name,
                color: Highcharts.getOptions().colors[item.index]
            };
        });

        // Create the chart
        Highcharts.chart('chartContainer', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Player Performance',
                align: 'left',
                style: {
                    fontSize: '10px'
                }
            },
            exporting: {
                enabled: false
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                itemMarginTop: 10, // Adjust the margin between legend items
                itemMarginBottom: 10,
                symbolHeight: 12, // Adjust the symbol height for color indicator
                labelFormatter: function () {
                    return this.name; // Only display the name in the legend
                }
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f}%',
                        distance: -30 // Adjust the distance of labels inside the pie
                    },
                    allowPointSelect: true,
                cursor: 'pointer',
            
                showInLegend: true

                }
            },
            series: [{
                name: 'Data',
                data: chartData
            }],
            tooltip: {
                formatter: function () {
                    return '<b>' + this.point.name + '</b>: ' + this.y;
                }
            }
        });
    });
    </script>
<?php
}
?>