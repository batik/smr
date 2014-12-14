<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productlist".
 *
 * @property integer $orderId
 * @property integer $productId
 * @property integer $quantity
 * @property string $price
 *
 * @property Order $order
 * @property Product $product
 */
class ProductList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderId', 'productId', 'quantity', 'price'], 'required'],
            [['orderId', 'productId', 'quantity'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderId' => 'Order ID',
            'productId' => 'Product ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'orderId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'productId']);
    }
}
