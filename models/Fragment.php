<?php

namespace app\models;

use yii\mongodb\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Fragment extends ActiveRecord
{
    public static function collectionName()
    {
        return 'fragments';
    }
    
    public function attributes()
    {
        return [
            '_id', 'type', 'code', 'user',
            'created_at','updated_at'
        ];
    }
    
    public function getTypes() {
        return ["public"=>"public","private"=>"private"];
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function rules()
    {
        return [
            [['type', 'code'], 'required'],
            [['type', 'code'], 'safe'],
            ['type','in','range'=>$this->types]
        ];
    }
    
    public function getId()
    {
        return (string)$this->_id;
    }
    
    public function getUsername() {
        return User::findIdentity($this->user)->username;
    }
}