<?php

namespace raphaelbsr\mktplace\controllers;

use raphaelbsr\gii\JsonEncoderHelper;
use raphaelbsr\mktplace\models\MktPlan;
use raphaelbsr\mktplace\models\MktPlanSearch;
use raphaelbsr\mktplace\models\MktProduct;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MktPlanController implements the CRUD actions for MktPlan model.
 */
class MktPlanController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MktPlan models.
     * @return mixed
     */
    public function actionIndex($id) {
        $product = MktProduct::findOne($id);
        if ($product) {
            $searchModel = new MktPlanSearch();
            $searchModel->product_id = $product->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'product' => $product,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single MktPlan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MktPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        $model = new MktPlan();

        try {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_SUCCESS, JsonEncoderHelper::MESSAGE_SUCCESS);
                } else {
                    return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_ERROR, JsonEncoderHelper::MESSAGE_ERROR, null, $model->errors);
                }
            } else {
                $product = MktProduct::findOne($id);
                $model->product_id = $product->id;
                return $this->renderAjax('create', [
                            'model' => $model,
                            'product' => $product,
                ]);
            }
        } catch (\Exception $e) {
            return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_ERROR, JsonEncoderHelper::MESSAGE_ERROR, null, $e->getMessage());
        }
    }

    /**
     * Updates an existing MktPlan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        try {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_SUCCESS, JsonEncoderHelper::MESSAGE_SUCCESS);
                } else {
                    return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_ERROR, JsonEncoderHelper::MESSAGE_ERROR, null, $model->errors);
                }
            } else {
                return $this->renderAjax('create', [
                            'model' => $model,
                ]);
            }
        } catch (\Exception $e) {
            return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_ERROR, JsonEncoderHelper::MESSAGE_ERROR, null, $e->getMessage());
        }
    }

    /**
     * Deletes an existing MktPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MktPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MktPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MktPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
