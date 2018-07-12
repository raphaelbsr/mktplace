<?php

namespace raphaelbsr\mktplace\modules\mktstore\controllers;

use raphaelbsr\mktplace\models\MktBilling;
use raphaelbsr\mktplace\models\MktContract;
use raphaelbsr\mktplace\models\MktCreditCard;
use raphaelbsr\mktplace\models\MktProduct;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Description of ProductController
 *
 * @author rapha
 */
class ProductController extends Controller {

    public function actionIndex() {
        
    }

    public function actionDetails($id) {

        if ($product = MktProduct::findOne($id)) {

            $dataProvider = new ActiveDataProvider(['query' => $product->getMktFeatures()]);
            $model = new MktContract();
            $model->product_id = $product->id;
            return $this->render('details', [
                        'model' => $model,
                        'product' => $product,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function actionPaymentPlans() {
        $contract = new MktContract();
        if ($contract->load(Yii::$app->request->post())) {

            $paymentPlans = $contract->product->paymentGroup->getMktPaymentPlans();
            $dataProvider = new ActiveDataProvider([
                'query' => $paymentPlans,
            ]);

            return $this->render('payment_plans', [
                        'contract' => $contract,
                        'dataProvider' => $dataProvider
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function actionPaymentInformation() {

        //die(print_r(Yii::$app->request->post()));
        $contract = new MktContract();
        $creditCard = new MktCreditCard();
        if ($contract->load(Yii::$app->request->post())) {
            return $this->render('payment-information', [
                        'contract' => $contract,
                        'creditCard' => $creditCard
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @todo CREATE A METHOD IN CONTRACT TO SAVE SENDING THE REQIRED PARAMETERS
     * @throws NotFoundHttpException
     */
    public function actionBilling() {

        $post = Yii::$app->request->post();
        $contract = new MktContract();
        $creditCard = new MktCreditCard();

        $transaction = Yii::$app->db->beginTransaction();

        $identity = Yii::$app->user->identity;
        $consumer = Yii::$app->mktplace->getConsumer($identity);
        $contract->consumer_id = $consumer->id;
        $contract->product_key = Yii::$app->security->generateRandomString(64);        
        if ($contract->load($post) && $creditCard->load($post)) {

            if ($contract->save()) {
                $billing = new MktBilling();
                $billing->consumer_id = $consumer->id;
                $billing->contract_id = $contract->id;
                $billing->amount = $contract->calcAmount();

                if ($billing->save()) {

                    //CALL BILLING COMPONENT TO VALIDATE CREDIT CARD BILL
                    if (true) {
                        $billing->payment_date = date('Y-m-d H:i:s');
                        $billing->save();
                        $transaction->commit();
                    }                    
                } else {
                    $transaction->rollBack();
                    throw new NotFoundHttpException(print_r($billing->errors));
                }
            } else {
                $transaction->rollBack();
                die(print_r($contract->errors));
                //throw new NotFoundHttpException();
            }
        } else {
            throw new NotFoundHttpException("Could not load contract and/or credit card");
        }
    }

}
