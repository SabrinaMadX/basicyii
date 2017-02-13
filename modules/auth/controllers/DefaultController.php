<?php

namespace app\modules\auth\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `auth` module
 */
class DefaultController extends Controller
{


	public function behaviors(){
    	return [
    		'verbs'=>[
    			'class'=>VerbFilter::className(),
    			'actions'=>[
    				'list'=>['get'],
                    'update'=>['put'],
    				'view'=>['get','head'],
                    'create'=>['post'],
    			],
    		],
    	];
    }

    public function beforeAction($action){
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        $bool = false;
        $headers =Yii::$app->request->headers;
        if($action->id == "index"){
            $bool = true;
        }else{
            if(isset($headers['X_BC_DEVID'])){
            $bool = true;
            }else{
                throw new \yii\web\ForbiddenHttpException();
            }
        }
        
        // other custom code here
        return $bool; // or false to not run the action
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$arr = [1,2,3];
        return ['content'=>$arr];
    }
}
