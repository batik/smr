<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\Role;
use app\models\Order;
use app\models\Comment;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $name
 * @property integer $roleId
 * @property string $email
 * @property string $passHash
 *
 * @property Comment[] $comments
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'roleId', 'email', 'passHash'], 'required'],
            [['roleId'], 'integer'],
            [['name', 'email', 'passHash'], 'string', 'max' => 256]
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
            'roleId' => 'Role ID',
            'email' => 'Email',
            'passHash' => 'Pass Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['userId' => 'id']);
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'roleId']);
    }

    public static function findByEmail($email) 
    {
        $user = User::find()->where(['email' => $email])->one();
        return $user;
    }

    public function validatePassword($password)
    {
        return $this->passHash == md5($password);
    }



    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = User::find()->where(['passHash' => $token])->one();
        return $user;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->email === $authKey;
    }

     public static function findIdentity($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        return $user;
    }
}
