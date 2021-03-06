<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['login', 'password', 'email', 'group_id'], 'safe'],
        ];
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
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('group');

        // grid filtering conditions
        $query->andFilterWhere([
            'users.id' => $this->id,
            'users.created_at' => $this->created_at,
            'users.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'users.login', $this->login])
            ->andFilterWhere(['like', 'users.email', $this->email])
            ->andFilterWhere(['like', 'groups.name', $this->group_id]);

        return $dataProvider;
    }
}
