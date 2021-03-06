<?php

namespace andahrm\structure\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\structure\models\PositionType;

/**
 * PositionTypeSearch represents the model behind the search form about `andahrm\structure\models\PositionType`.
 */
class PositionTypeSearch extends PositionType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','person_type_id', 'note', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PositionType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,            
            'person_type_id' => $this->person_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['note', 'title', $this->note]);

        return $dataProvider;
    }
}
