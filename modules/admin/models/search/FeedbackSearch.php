<?php

namespace app\modules\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Feedback;

/**
 * FeedbackSearch represents the model behind the search form of `app\modules\admin\models\Feedback`.
 */
class FeedbackSearch extends Feedback
{
    public $date_from;
    public $date_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['message', 'user.name'], 'safe'],
            [['date_to', 'date_from'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.name', 'images', 'date_add',]); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
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
        $query = Feedback::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
        ]);
        $query->JoinWith(['user' => function ($query) {
            $query->from(['user' => 'users']);
        }]);
        $dataProvider->sort->attributes['user.name'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],

        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
//            'date_add' => $this->date_add,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['LIKE', 'user.name', $this->getAttribute('user.name')]);


        //newfieldrange работает, работает с DAtepicker, поле - дата пхп
        if (!empty($this->date_from) and !empty($this->date_to)){
            $query->andFilterWhere(['>=', 'feedback.date_add', $this->date_from])->andFilterWhere(['<=', 'feedback.date_add', $this->date_to]);
    }

        return $dataProvider;
    }
}
