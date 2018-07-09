<?php

namespace raphaelbsr\mktplace\controllers;

use app\models\MktFeatureSearch;
use raphaelbsr\gii\JsonEncoderHelper;
use raphaelbsr\mktplace\models\MktProduct;
use raphaelbsr\mktplace\models\MktProductSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MktProductController implements the CRUD actions for MktProduct model.
 */
class MktProductController extends Controller {

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
     * Lists all MktProduct models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MktProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MktProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MktProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MktProduct();

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
     * Creates / Updates a existing MktFeature model related from MktProduct
     * @param integer $id MktProduct id
     * @return mixed
     */
    public function actionFeatures($id) {

        $product = MktProduct::findOne($id);
        if ($product) {
            $searchModel = new MktFeatureSearch();
            $searchModel->product_id = $product->id;
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            return $this->render('features', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'product' => $product,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing MktProduct model.
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
     * Deletes an existing MktProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MktProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MktProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MktProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
