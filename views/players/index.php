<?php

use app\models\Players;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PlayersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Predicted YOUR Playing X1';
?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax-grid-view']); ?>

<div class="players-index">
    <div class="card">
      <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
        
      </div>
      <div class="card-body table-responsive">
   
        <div class="row ">
          <div class="col-sm-6">
            <div class="table-responsive">
              <?=
              GridView::widget([
                  'dataProvider' => $dataProvider,
                  'tableOptions' => ['class' => 'table table-striped table_squad'],
                  'summary' => '', // Disable the summary section
                  'columns' => [
                      [
                          'attribute' => 'name',
                          'label' => 'Our Squad',
                          'headerOptions' => ['class' => 'custom-header-class'],
                          'contentOptions' => function ($model, $key, $index, $column) {
                              return ['data-id' => $model->id, 'draggable' => 'true'];
                          },
                      ],
                      [
                          'attribute' => 'type',
                          'label' => 'Player Type',
                          'headerOptions' => ['class' => 'custom-header-class'],
                          'value'=>function($model){
                              if($model->type == 1) return "All Rounder";
                              if($model->type == 2) return "Bowler";
                              if($model->type == 3) return "Batsman";
                              if($model->type == 4) return "Wicket Keeper";
                          }
                      ],
                      [
                          'class' => 'yii\grid\ActionColumn',
                          'template' => '{update} {delete}', // Adjust the buttons as needed
                          'buttons' => [
                              'update' => function ($url, $model, $key) {
                                  return Html::a('<i class="fa fa-edit"></i>', $url, [
                                      'title' => 'Edit',
                                      'class' => 'viewModallgBtn',
                                      'data-title' => 'Edit player Squad',  
                                  ]);
                              },
                              'delete' => function ($url, $model, $key) {
                                  return Html::a('<i class="fa fa-trash text-danger"></i>', $url, [
                                      'title' => 'Delete',
                                      'data-confirm' => 'Are you sure you want to delete this item?',
                                      'data-method' => 'post',
                                  ]);
                              },
                          ],
                          
                          
                      ],
                  ],
              ]);
              ?>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="table-responsive">
              <?= Html::beginForm(['store-predictions'], 'post', ['id' => 'prediction-form']) ?>

              <?= GridView::widget([
              'dataProvider' => $predict,
              'tableOptions' => ['class' => 'table table-striped table_predict'],
              'summary' => '', // Disable the summary section
              'columns' => [
                  [
                      'attribute' => 'player_id',
                      'label' => 'Predicted your Playing X1',
                      'headerOptions' => ['class' => 'custom-header-class'],
                      'contentOptions' => ['class' => 'column-name'],
                      'value' => function ($model) {
                          return $model->player->name;
                      }
                  ],
                  [
                      'attribute' => 'score',
                      'label' => 'Score',
                      'format' => 'raw',
                      'headerOptions' => ['class' => 'custom-header-class'],
                      'contentOptions' => ['class' => 'column-score'],
                      'value' => function ($model) {
                          $score = $model->score; // Assuming 'score' is the attribute name in the database
                          return '<input type="text" class="form-control" name="input_' . $model->id . '" value="' . $score . '" onkeypress="return /[0-9\s]/i.test(event.key)" maxlength="5">';
                      },
                  ],
                  [
                      'class' => 'yii\grid\ActionColumn',
                      'template' => '{delete}', // Adjust the buttons as needed
                      'buttons' => [
                      
                          'delete' => function ($url, $model, $key) {
                              $url = Url::to(['predict-player/delete', 'id' => $model->id]);
                              return Html::a('<i class="fa fa-times"></i>', $url, [
                                  'title' => 'Remove from Predict',
                                  'data-confirm' => 'Are you sure you want to Remove this Player?',
                                  'data-method' => 'post',
                              ]);
                          },
                      ],
                      
                      
                  ],
              ],
              ]); ?>
           </div>
        </div>
    </div>
  </div>
  <?= Html::endForm() ?>  
  <div class="card-footer">
    <div class="btnrow">

        <?= Html::a('Add', yii\helpers\Url::to(['create']), ['data-bs-toggle' => 'tooltip', 'data-bs-original-title' => 'Add player to Squad', 'class' => 'btn viewModallgBtn', 'data-title' => "Add player to Squad"]) ?>
        <?= Html::Button('Predict', ['class' => 'btn submit_btn', 'name' => 'predict-button', 'style'=>'margin-right: 10px;']) ?>
        <?= Html::a('View', ['view'], ['class' => 'btn ']) ?>

    </div>
    </div>
</div>
    
</div>
    <?php Pjax::end(); ?>
<script>

$(function() {
  // Function to initialize draggable and sortable elements
  function initializeDraggableElements() {
    $(".table_predict tbody, .table_squad tbody").sortable({
      connectWith: ".table_predict tbody, .table_squad tbody",
      placeholder: "sortable-placeholder",
      helper: "clone",
      start: function(event, ui) {
        ui.item.toggleClass("sortable-dragging");
      },
      stop: function(event, ui) {
        ui.item.toggleClass("sortable-dragging");
        updateSortOrder('table_predict');
        updateSortOrder('table_squad');
        updateDatabase('table_predict');
        updateDatabase('table_squad');
      }
    }).disableSelection();
  }

  // Update the sort order within the specified table
function updateSortOrder(tableId) {
  $('.' + tableId + ' tbody tr').each(function(index) {
    var isEmptyElement = $(this).hasClass('empty');
    if (!isEmptyElement) {
      $(this).attr('data-sort-order', index + 1);
    }
  });
}


  // Update the database with the new order
  function updateDatabase(tableId) {
  var draggableElements = $('.' + tableId + ' tbody tr');

  // Check if there are draggable elements
  if (draggableElements.length === 0) {
    console.log('No draggable elements found');
    return; // Skip AJAX request
  }

  var data = [];
  draggableElements.each(function(index) {
    var isEmptyElement = $(this).hasClass('empty');
    if (!isEmptyElement) {
      var playerId = $(this).data('key');
      var sortOrder = $(this).data('sort-order');
      data.push({ id: playerId, sort_order: sortOrder });
    }
  });
  
  // Add an empty object to data if it is empty
  if (data.length === 0) {
    data.push({});
  }

  $.ajax({
    url: '<?php echo Url::to(['update-sortorder']); ?>',
    method: 'POST',
    data: { data: data, table: tableId },
    success: function(response) {
      console.log('Database updated successfully');
      $.pjax.reload({
        container: "#pjax-grid-view",
        timeout: false
      });
    },
    error: function(xhr, status, error) {
      $.pjax.reload({
        container: "#pjax-grid-view",
        timeout: false
      });
      // console.error('Error updating database:', error);
    }
  });
}


  $(document).on('click', '.submit_btn', function(e) {
    e.preventDefault();

    var formData = $('#prediction-form').serialize();

    $.ajax({
      url: '<?php echo Url::to(['store-predictions']); ?>',
      method: 'POST',
      data: formData,
      success: function(response) {
        alert('Prediction added successfully!');
        $.pjax.reload({
          container: "#pjax-grid-view",
          timeout: false
        });
      },
      error: function(xhr, status, error) {
        console.error('Error storing predictions:', error);
      }
    });
  });

  $(document).on('pjax:success', function() {
    initializeDraggableElements();
  });

  // Initialize draggable elements on page load
  initializeDraggableElements();
});


</script>
<style>
    .sortable-placeholder {
  background-color: #f5f5f5;
  border: 2px dashed #bbb;
  height: 40px;
}

.sortable-dragging {
  opacity: 0.5;
}

</style>
