<?php

namespace raphaelbsr\mktplace\controllers;

use raphaelbsr\gii\JsonEncoderHelper;
use raphaelbsr\mktplace\models\MktPaymentGroup;
use raphaelbsr\mktplace\models\MktPaymentPlan;
use raphaelbsr\mktplace\models\MktPaymentPlanSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MktPaymentPlanController implements the CRUD actions for MktPaymentPlan model.
 */
class MktPaymentPlanController extends Controller {

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
     * Lists all MktPaymentPlan models.
     * @return mixed
     */
    public function actionIndex($id) {

        if ($paymentGroup = MktPaymentGroup::findOne($id)) {
            $searchModel = new MktPaymentPlanSearch();
            $searchModel->payment_group_id = $paymentGroup->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'paymentGroup' => $paymentGroup
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Displays a single MktPaymentPlan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MktPaymentPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        $model = new MktPaymentPlan();

        try {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_SUCCESS, JsonEncoderHelper::MESSAGE_SUCCESS);
                } else {
                    return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_ERROR, JsonEncoderHelper::MESSAGE_ERROR, null, $model->errors);
                }
            } else {
                $paymentGroup = MktPaymentGroup::findOne($id);
                $model->payment_group_id = $paymentGroup->id;
                return $this->renderAjax('create', [
                            'model' => $model,
                ]);
            }
        } catch (\Exception $e) {
            return JsonEncoderHelper::encodeJsonResponse(JsonEncoderHelper::STATUS_ERROR, JsonEncoderHelper::MESSAGE_ERROR, null, $e->getMessage());
        }
    }

    /**
     * Updates an existing MktPaymentPlan model.
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
     * Deletes an existing MktPaymentPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MktPaymentPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MktPaymentPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MktPaymentPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
