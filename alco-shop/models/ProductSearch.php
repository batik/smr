<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{


    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['category.name', 'minPrice', 'maxPrice']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isAvailable', 'categoryId', 'rating', 'ratingAmount'], 'integer'],
            [['name', 'description', 'photo'], 'safe'],
            [['price'], 'number'],
            [['category.name', 'minPrice', 'maxPrice'], 'safe']
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
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['category.name'] = [
            'asc' => ['category.name' => SORT_ASC],
            'desc' => ['category.name' => SORT_DESC],
        ];
        $query->joinWith(['category']);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'product.id' => $this->id,
            'price' => $this->price,
            'isAvailable' => $this->isAvailable,
            'rating' => $this->rating,
            'ratingAmount' => $this->ratingAmount,
        ]);

        $query->andFilterWhere(['in','categoryId', $this->getChildCategories()]);

        $query->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'category.name', $this->getAttribute('category.name')])
            ->andFilterWhere(['>=', 'price', $this->getAttribute('minPrice')])
            ->andFilterWhere(['<=', 'price', $this->getAttribute('maxPrice')]);

        return $dataProvider;
    }
}
