<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $totalPrice
 * @property string $date
 * @property integer $paymentStatus
 *
 * @property Productlist[] $productlists
 * @property Product[] $products
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'totalPrice', 'date', 'paymentStatus'], 'required'],
            [['userId', 'paymentStatus'], 'integer'],
            [['totalPrice'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'totalPrice' => 'Total Price',
            'date' => 'Date',
            'paymentStatus' => 'Payment Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'productId'])->viaTable('{productlist}', ['orderId' => 'id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
