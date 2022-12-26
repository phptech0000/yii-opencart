<?php

namespace app\models;
use yii\base\Model;
use yii;
// use floor12\phone\PhoneValidator;

class PageForm extends Model
{
    public $lang_code;
    public $file_name;

    public function rules()
    {
        return [
            [['lang_code', 'file_name'], 'required'],
            [['lang_code', 'file_name'], 'string', 'max'=>255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang_code' => 'Language',
            'file_name' => 'File Name',
        ];
    }
}