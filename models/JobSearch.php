<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Job;

/**
 * JobSearch represents the model behind the search form of `app\models\Job`.
 */
class JobSearch extends Job
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['job_title', 'job_detail', 'job_file', 'send_department', 'send_officer', 'job_deadline', 'line_alert', 'created_at', 'updated_at', 'accepted_at', 'accepted_by', 'accepted_officer', 'status', 'note'], 'safe'],
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
        $query = Job::find();
        $query->joinWith(['department','jobstatus']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'job_deadline' => $this->job_deadline,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'accepted_at' => $this->accepted_at,
        ]);

        $query->andFilterWhere(['like', 'job_title', $this->job_title])
            ->andFilterWhere(['like', 'job_detail', $this->job_detail])
            ->andFilterWhere(['like', 'job_file', $this->job_file])
            ->andFilterWhere(['like', 'send_department', $this->send_department])
            ->andFilterWhere(['like', 'send_officer', $this->send_officer])
            ->andFilterWhere(['like', 'line_alert', $this->line_alert])
            ->andFilterWhere(['like', 'accepted_by', $this->accepted_by])
            ->andFilterWhere(['like', 'accepted_officer', $this->accepted_officer])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
