<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $confirmation;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'name'], 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            // password is validated by validatePassword()
            ['password', 'match', 'pattern'=>'/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,10}$/', 
                'message' => 'Please, enter more secure password'],
            ['password', 'validatePassword'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Your name',
            'email' => 'Your Email',
            'password' => 'Password',
            'confirmation' => 'Password Confirmation',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->confirmation!=$this->password)
            $this->addError('confirmation','Password and Password Confirmation are not the same');
    }


    public function validateEmail($attribute, $params)
    {
        $userCount = User::find()->where(['email'=>$this->email])->count();

        if ($userCount!=0)
            $this->addError('email','This email is being used already');
    }

   public function register()
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->passHash = md5($this->password);
        $user->roleId = 2;
        return $user->save(false);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
