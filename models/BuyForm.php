<?php

namespace app\models;
use yii\base\Model;

class BuyForm extends Model
{
    public $first_name;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // first_name, email, and body are required
            [['first_name', 'email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }
}
