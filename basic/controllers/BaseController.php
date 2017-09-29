<?php

namespace app\controllers;

use yii\web\Controller;
use common\CommonFun;
class BaseController extends Controller
{
    /**
     * 取消csrf
     * @var boolean
     */
    public $enableCsrfValidation = false;
    /**
     * 解决跨域请求问题
     * @return array behavior
     */
   //  public function behaviors()
   //  {
   //      return [
   //     'corsFilter' => [
   //         'class' => \yii\filters\Cors::className(),
   //     ],
   // ];
   //      // return array_merge(parent::behaviors(), [
   //      //     'corsFilter' => [
   //      //         'class' => \yii\filters\Cors::className(),
   //      //         'cors' => [
   //      //             'Origin' => ['*'],
   //      //             // 'Access-Control-Allow-Origin' => 'http://127.0.0.1:9999',
   //      //             'Access-Control-Request-Method' => ['POST','OPTIONS','GET'],
   //      //             'Access-Control-Allow-Credentials' => true,
   //      //             'Access-Control-Max-Age' => 86400,
   //      //
   //      //         ],
   //      //     ],
   //      // ]);
   //  }
    public function beforeAction($action)
    {

        $headers = \Yii::$app->response->headers;
        //解决跨域请求
        $headers->add('Accept','application/json');
        $headers->add('Content-Type','application/json;charset=UTF-8');
        $headers->add('Accept-Charset','UTF-8');
        // $headers->add('Access-Control-Allow-Origin', '*');
        // $headers->add('Access-Control-Allow-Headers', 'content-type,token');
        // $headers->add('Access-Control-Allow-Methods','POST,GET,OPTIONS');
    }

}
