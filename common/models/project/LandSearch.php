<?php

namespace common\models\project;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\project\Land;

/**
 * LandSearch represents the model behind the search form about `common\models\project\Land`.
 */
class LandSearch extends Land
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'deleted', 'portion_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'code', 'created_at', 'updated_at','acreage','location'], 'safe'],
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
        $query = Land::find()->active();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'acreage'=> $this->acreage,
            'location'=>$this->location,
            'deleted' => $this->deleted,
            'portion_id' => $this->portion_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
