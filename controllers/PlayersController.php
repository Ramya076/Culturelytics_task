<?php

namespace app\controllers;

use app\models\Players;
use app\models\PlayersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use app\models\PredictPlayer;
use app\models\PredictPlayerSearch;

/**
 * PlayersController implements the CRUD actions for Players model.
 */
class PlayersController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    /**
     * Lists all Players models.
     *
     * @return string
     */
    public function actionIndex() {
        $searchModel = new PlayersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $predict = (new PredictPlayerSearch())->search($this->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'predict' => $predict
        ]);
    }

    public function actionRemovePlayer() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $draggedId = Yii::$app->request->post('draggedId');

        // Find the dragged player and update the sort_order field
        $draggedPlayer = PredictPlayer::findOne(['player_id'=>$draggedId]);
        if ($draggedPlayer) {
            $draggedPlayer->delete();
            return ['success' => true];
        }

        return ['success' => false];
    }
    public function actionDragPlayer() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $draggedId = Yii::$app->request->post('draggedId');

        // Find the dragged player and update the sort_order field
        $draggedPlayer = new PredictPlayer();
        if ($draggedPlayer) {
            $draggedPlayer->player_id = $draggedId;
            $draggedPlayer->save();
            return ['success' => true];
        }

        return ['success' => false];
    }

    /**
     * Displays a single Players model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView() {
         $searchModel = new PlayersSearch();
        $dataProvider = (new PredictPlayerSearch())->predictview($this->request->queryParams);
      
        return $this->render('view', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
                    
        ]);
    }

    /**
     * Creates a new Players model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        $model = new Players();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Players model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('update', [
                    'model' => $model,
        ]);
    }

    public function actionUpdateSortorder()
{
    Yii::$app->response->format = Response::FORMAT_JSON;

    if (Yii::$app->request->isAjax) {
        $postData = Yii::$app->request->post();

        // Retrieve the data sent from the client-side
        $data = $postData['data'] ?? []; // Add a null coalescing operator to handle empty data array
        $tableId = $postData['table'];

        $success = true; // Variable to track the overall success

        // Process and update the sort order in the database
        // Iterate through the received data and update the corresponding records in the database
       if(!empty($data)){

       
        foreach ($data as $index => $item) {
            $sortOrder = $item['sort_order'];
            $id = $item['id'];
            if (!empty($id)) {
                if ($tableId == 'table_predict') {
                    $model = PredictPlayer::findOne(['id' => $id]);
                    if (empty($model)) {
                        $model = new PredictPlayer();
                        $model->player_id = $id;
                        $model->sort_order = $sortOrder;
                    } else {
                        $model->sort_order = $sortOrder;
                    }
                    $model->save(false);
                    $success = true;

                } elseif ($tableId == 'table_squad') {
                    $model = Players::findOne(['id' => $id]);
                    if (!empty($model)) {
                        $model->sort_order = $sortOrder;
                        $model->save(false);
                        $success = true;
                    } else {
                        $model = PredictPlayer::findOne(['id' => $id]);
                        if (!empty($model)) {
                            $model->delete(); // remove the player from predict
                        }
                        $success = true;
                    }

                }
            }
        }
        }else{
            if($tableId == 'table_predict'){
                (PredictPlayer::find()->one())->delete();
            }
        }
        if ($success) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    return ['success' => false];
}

    

    /**
     * Deletes an existing Players model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        
        $predict_player = PredictPlayer::findOne(['player_id'=>$id]);
        if(!empty($predict_player)){
            $predict_player->delete();        
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Players model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Players the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Players::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionStorePredictions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $inputs = Yii::$app->request->post();
            unset($inputs['_csrf']); // Remove the CSRF token from the input data

            $success = true; // Variable to track the overall success

            foreach ($inputs as $key => $value) {
                // Extract the player ID from the input key
                $playerId = substr($key, strlen('input_'));

                // Find the corresponding player prediction record and update the score
                $prediction = PredictPlayer::findOne($playerId);
                if ($prediction) {
                    $prediction->score = $value;

                    if (!$prediction->save(false)) {
                        $success = false; // Set the success variable to false if saving fails for any prediction
                    }
                }
            }

            if ($success) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        }

        return ['success' => false];
    }


}