<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Testimonials;

/**
 * TestimonialsSearch represents the model behind the search form about `frontend\models\Testimonials`.
 */
class TestimonialsSearch extends Testimonials {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'smile', 'parent_id'], 'integer'],
            [['text', 'created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Testimonials::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        //$this->parent_id = 0;
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'smile' => $this->smile,
            'parent_id' => 0,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

}
