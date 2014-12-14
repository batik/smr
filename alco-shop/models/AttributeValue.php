<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attributevalue".
 *
 * @property integer $productId
 * @property integer $attributeId
 * @property string $value
 *
 * @property Product $product
 * @property Attribute $attribute
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attributevalue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'attributeId', 'value'], 'required'],
            [['productId', 'attributeId'], 'integer'],
            [['value'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productId' => 'Product ID',
            'attributeId' => 'Attribute ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'productId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryAttribute()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attributeId']);
    }
}
