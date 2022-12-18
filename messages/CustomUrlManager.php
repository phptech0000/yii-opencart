<?php
namespace app\messages;

use Yii;
use yii\web\UrlManager;

class  CustomUrlManager  extends  UrlManager 
{ 
    public  function  createUrl ( $route , $params = array ( ) , $ampersand = ' & ' ) 
    { 
        if  ( empty ( $params [ ' language ' ] ) )  { 
            $params [ ' language ' ] = Yii ::$app->language ;
        } 
        return  parent :: createUrl ( $route , $params , $ampersand ) ;
    } 
}