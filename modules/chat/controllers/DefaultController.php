<?php

namespace app\modules\chat\controllers;

use yii\rest\Controller;
use yii\filters\VerbFilter;
use vendor\XMPP_Conn;
use Fabiang\Xmpp\Util\XML;
use Fabiang\Xmpp\Options;
use Fabiang\XMpp\Client;
use Yii;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
	public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['verbFilter']= [
            'class'=>VerbFilter::className(),
            'actions'=>[
                    'register'=>['post'],
                    'update'=>['put'],
                    'view'=>['get','head'],
                    'create'=>['post'],
                ],
        ];
        return $behaviors;
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$name = ['FAMILY'=> 'Wood', 'GIVEN'=>'Elijah'];
    	$dob = '1981-01-28';
    	$org =['ORGNAME'=>'The Fellowship of the Rings', 'ORGUNIT'=>'Ring Bearer'];
    	$title = 'Mr';
    	$tel = ['WORK'=>'', 'VOICE'=>'', 'NUMBER'=>'012-345-6789'];
    	$role = 'Frodo Baggins';
    	$jid = "";

    	$content = ['vcard'=>
    		[
    			'N'=>$name, 
    			'BDAY'=>$dob, 
    			'ORG'=>$org, 
    			'TITLE'=>$title, 
    			'ROLE'=>$role, 
    			'JABBERID'=>$jid,
    			'TEL'=>$tel, 
    			'DESC'=>"vcard example"
    		]
    	];
        return $content;
    }

    public function actionRegister(){
    	$post = Yii::$app->request->post();
    	if($this->updateUser($post)){
    		return ;
    	}else throw new \yii\web\BadRequestHttpException("didnt manage to register", 400);
    	 
    }

    private function updateUser($post){
	/* update to local app database then update ejabberd database by calling api/set_vcard. 
	 * only continue of both are true
	 * variables: n[family given], bday, org[orgname, orgunit], title, role  
	 */
    	$xmpp_updated = false;
    	$local_updated= false;
    	$ok = false;
    	if($xmpp_updated && $local_updated){
    		$ok = true;
    	}
    	return $ok;    	
    }

    public function registerChatUser($name, $password, $email){
		$address = 'tcp://ejabberd.bombwithme.com:5222';
		$adminUser = 'admin';
		$adminPW = 'admin_password';

		$options = new Options($address);
		$options->setUsername($adminUser)->setPassword($adminPW);
		$client = new Client($options);
		$client->connect();
		$register = new XMPP_Conn($name, $password,$email);
		$client->send($register);
		$client->disconnect();
	}
}
