<?php

namespace app\common;

use yii\base\Component;

class MyHelper extends Component {

    public static function isAdmin() {
        if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->username == 'admin') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public static function isUser() {
        if (!\Yii::$app->user->isGuest &&  \Yii::$app->user->identity->username <> 'admin') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    

}
