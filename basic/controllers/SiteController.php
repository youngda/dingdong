<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Data;
use common\CommonFun;

class SiteController extends BaseController
{
    public function beforeAction($action)
    {
        parent::beforeAction($action);

        return true;
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $post = Yii::$app->request->post();

        $get = Yii::$app->request->get();
        $newData = new Data();
        $newData['id'] = CommonFun::CreateId();
        $newData['get'] = json_encode($get);
        $newData['post'] = json_encode($post);
        $newData['ip'] = CommonFun::GetClientIp();
        $newData['time'] = time();
        $newData->save();
        //
        $res['directive']['directive_items'][] = ['content'=>'好的，已帮您关闭了客厅灯','type'=>'1'];
        $res['extend']['NO_REC'] = '0';
        $res['is_end'] = true;
        // $res['sequence'] = $post['sequence'];
        $res['repeat_directive']['type'] = '1';
        $res['repeat_directive']['content'] = '听不懂你在说什么';
        $res['timestamp'] = time();
        $res['versionid'] = '1.0';
        echo json_encode($res);

        // $newData->save();

        // {
        //     "directive": {
        //         "directive_items": [
        //             {
        //                 "content": "好的，已帮您关闭了客厅灯",
        //                 "type": "1"
        //             }
        //         ]
        // },
        // "extend":{"NO_REC":"0"},
        //     "is_end":true,
        //     "sequence":"f10ee90bcff644cdab1ed2a18c4ddd63",
        //     "timestamp":1483609208020,
        //     "versionid": "1.0"
        // }

        // return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
