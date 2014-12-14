<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attribute".
 *
 * @property integer $id
 * @property string $name
 * @property integer $categoryId
 * @property string $unit
 *
 * @property Category $category
 * @property Attributevalue[] $attributevalues
 * @property Product[] $products
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'categoryId'], 'required'],
            [['categoryId'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['unit'], 'string', 'max' => 20],
            ['name', 'checkParentCategories'],
        ];
    }

    public function checkParentCategories($attribute, $params)
    {   
        $parent = $this->getCategory()->one()->getParent()->one();
        if($parent && $parent->getCategoryAttributes()->where(['name' => $this->name])->count() != 0)
        {
            $this->addError($attribute, 'There is attribute with the same name in the parent category.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'categoryId' => 'Category ID',
            'unit' => 'Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'categoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['attributeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'productId'])->viaTable('{attributevalue}', ['attributeId' => 'id']);
    }
}
