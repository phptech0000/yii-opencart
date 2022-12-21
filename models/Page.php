<?php

namespace app\models;
use yii\base\Model;

class Page extends Model
{
    public $content;
    public function rules()
    {
        return [
            [['content'], 'required'],
        ];
    }
}
