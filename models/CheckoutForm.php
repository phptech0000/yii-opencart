<?php

namespace app\models;
use yii\base\Model;
// use floor12\phone\PhoneValidator;

class CheckoutForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $street1;
    public $street2;
    public $zip;
    public $country;
    public $city;
    public $lang;
    public $payment_method;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone', 'street1', 'street2', 'zip', 'city', 'country', 'lang'], 'required'],
            [['first_name', 'last_name', 'email', 'phone', 'street1', 'street2', 'zip', 'city', 'country', 'lang'], 'string', 'max'=>255],
            ['email', 'email'],
            // ['phone', PhoneValidator::class]
        ];
    }
}