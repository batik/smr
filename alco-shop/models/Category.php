<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 * @property string $photo
 *
 * @property Attribute[] $attributes
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId'], 'integer'],
            [['name'], 'required'],
            [['name', 'photo'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentId' => 'Parent ID',
            'name' => 'Name',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryAttributes()
    {
        return $this->hasMany(Attribute::className(), ['categoryId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['categoryId' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Category::classname(), ['id' => 'parentId']);
    }

    public function getChilds()
    {
        return $this->hasMany(Category::classname(), ['parentId' => 'id']);
    }
}
