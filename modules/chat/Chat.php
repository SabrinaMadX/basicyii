<?php

namespace app\modules\chat;
use Yii;
/**
 * chat module definition class
 */
class Chat extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\chat\controllers';

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
