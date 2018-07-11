<?php

namespace raphaelbsr\mktplace\modules\store\models;

use raphaelbsr\mktplace\models\MktProduct;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of MktProductSearch
 *
 * @author rapha
 */
class MktProductSearch extends MktProduct{    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['create_time', 'update_time', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function search($params){
        
        $query = MktProductSearch::find();                
        $dataProvider = new ActiveDataProvider(['query' => $query]);                
        $query->andWhere(['isactive' => 1]);               
        return $dataProvider;
        
    }
    
}
