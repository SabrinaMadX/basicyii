<?php

namespace app\modules\auth;
use Yii;
/**
 * auth module definition class
 */
class Auth extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\auth\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // parent::init();
        Yii::$app->request->parsers = ['application/json' => '\yii\web\JsonParser'];
        $headers = Yii::$app->response->headers;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
        // custom initialization code goes here
    }
}
