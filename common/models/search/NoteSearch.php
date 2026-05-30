<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Note;

/**
 * NoteSearch represents the model behind the search form of `common\models\Note`.
 */
class NoteSearch extends Note
{
    public $q;
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'is_pinned'], 'integer'],
            [['title', 'content', 'color', 'created_at', 'updated_at', 'q'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search(array $params, $formName = null): ActiveDataProvider
    {
        $query = Note::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['is_pinned' => SORT_DESC, 'created_at' => SORT_DESC],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->q) {
            $query->andFilterWhere([
                'or',
                ['like', 'title', $this->q],
                ['like', 'content', $this->q],
            ]);
        }

        return $dataProvider;
    }
}
