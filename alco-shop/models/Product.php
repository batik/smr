<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property integer $isAvailable
 * @property integer $categoryId
 * @property string $photo
 * @property integer $rating
 * @property integer $ratingAmount
 *
 * @property Attributevalue[] $attributevalues
 * @property Attribute[] $attributes
 * @property Comment[] $comments
 * @property Pricesnapshot[] $pricesnapshots
 * @property Category $category
 * @property Productlist[] $productlists
 * @property Order[] $orders
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'price', 'isAvailable', 'categoryId'], 'required'],
            [['price'], 'number'],
            [['isAvailable', 'categoryId', 'rating', 'ratingAmount'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 500],
            ['price', 'match', 'pattern'=>'/^\d+\.\d{2}$/', 'message' => 'Пожалуйста, введите корректную цену.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'isAvailable' => 'Is Available',
            'categoryId' => 'Category ID',
            'photo' => 'Photo',
            'rating' => 'Rating',
            'ratingAmount' => 'Rating Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributevalues()
    {
        return $this->hasMany(AttributeValue::className(), ['productId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attributeId'])->viaTable('{attributevalue}', ['productId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['productId' => 'id']);
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
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'orderId'])->viaTable('{productlist}', ['productId' => 'id']);
    }

    public function getChildCategories()
    {
        $res = $this->getCategory()->select(['id as categoryId'])->asArray()->all();
        $arr2 =  $this->getCategory()->one()->getChilds()->select(['id as categoryId'])->asArray()->all();
        $res = array_merge($res, $arr2);
        return $res;
    }
}
