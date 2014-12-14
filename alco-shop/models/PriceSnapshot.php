<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pricesnapshot".
 *
 * @property integer $productId
 * @property string $price
 * @property string $expireDate
 * @property integer $id
 *
 * @property Product $product
 */
class PriceSnapshot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pricesnapshot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'price'], 'required'],
            [['productId'], 'integer'],
            [['price'], 'number'],
            [['expireDate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productId' => 'Product ID',
            'price' => 'Price',
            'expireDate' => 'Expire Date',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'productId']);
    }
}
