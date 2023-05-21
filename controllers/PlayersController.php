<?php

namespace app\controllers;

use app\models\Players;
use app\models\PlayersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

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
        $predict = $searchModel->predict($this->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'predict' => $predict
        ]);
    }

    public function actionDragPlayer() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $draggedId = Yii::$app->request->post('draggedId');

        // Find the dragged player and update the sort_order field
        $draggedPlayer = Players::findOne($draggedId);
        if ($draggedPlayer) {
            $draggedPlayer->sort_order = $draggedId;
            $draggedPlayer->save(false);
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
        $dataProvider = $searchModel->predictview($this->request->queryParams);
      
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Players model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
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
            $prediction = Players::findOne($playerId);
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
