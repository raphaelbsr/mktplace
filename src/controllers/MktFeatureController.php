<?php

namespace raphaelbsr\mktplace\controllers;

use raphaelbsr\gii\JsonEncoderHelper;
use raphaelbsr\mktplace\models\MktFeature;
use raphaelbsr\mktplace\models\MktFeatureSearch;
use raphaelbsr\mktplace\models\MktProduct;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MktFeatureController implements the CRUD actions for MktFeature model.
 */
class MktFeatureController extends Controller {

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
     * Lists all MktFeature models.
     * @return mixed
     */
    public function actionIndex($id) {

        $product = MktProduct::findOne($id);
        if ($product) {
            $searchModel = new MktFeatureSearch();
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
     * Displays a single MktFeature model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MktFeature model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {

        $model = new MktFeature();
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
     * Updates an existing MktFeature model.
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
     * Deletes an existing MktFeature model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MktFeature model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MktFeature the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MktFeature::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
