<?php
namespace frontend\controllers;

use common\models\User;
use EasyWeChat\Factory;
use frontend\models\EntryForm;
use moonland\phpexcel\Excel;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\components\ActionTimeFilter;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'class' => ActionTimeFilter::className(),
                'only' => ['logout', 'signup', 'say'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'say'],
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
     * {@inheritdoc}
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        $files = UploadedFile::getInstanceByName('file');
        $filename = $files->tempName;
        $name = $files->name;
        $basePath = Yii::$app->basePath;
        $url = $basePath.'/uploads/'.$name;
        copy($filename, $url);
        $das = Excel::import($url);
        VarDumper::dump($das, 10, true);
        die;

        $file = $_FILES;
        $filename = $file['file']['tmp_name'];
//        echo $filename;
        $data = Excel::import($filename);
        VarDumper::dump($data, 10, true);
        VarDumper::dump($file);
    }

    /**
     * 测试
     */
    public function actionSay($message = 'hello')
    {
        $config = Yii::$app->params['wechat']['hzy'];
        $app = Factory::miniProgram($config);
//        $temList = $app->template_message->list(3,10);
//        $key = $app->template_message->get('AT0007');
//        $add = $app->template_message->add('AT0007', [2,3]);
//        $myTem = $app->template_message->getTemplates(1, 3);
//        VarDumper::dump($app, 10, true);
//        VarDumper::dump($temList, 10, true);
//        VarDumper::dump($key, 10, true);
//        VarDumper::dump($add, 10, true);
//        VarDumper::dump($myTem, 10, true);
        $res = $app->template_message->send([
            'touser' => 'ouU_r4g10X0aTA3693OahlvonKgQ',
            'template_id' => 'wINPzjIDYmzuVAOrwSAXn6StlFz9S9lRVnGnXilpZUQ',
            'page' => 'index',
            'form_id' => 'from_id',
            'data' => [
                'title' => '付款成功通知',
                'content' => '付款金额',
                'example' => '这个是啥'
            ]
        ]);
        VarDumper::dump($res);
        die;
//        $data = $_FILES;
//        if ($data) {
//            $filename = $data['User']['tmp_name']['auth_key'];
////            echo $filename;
//            $test = Excel::import($filename);
//            if ($test) {
//                foreach ($test as $key => $value) {
//                    VarDumper::dump($value, 10, true);
//                }
//            }
//            VarDumper::dump($test, 10, true);
//            VarDumper::dump($data);
//            die;
//        }
//        $foo = new User();
//
//        $foo->on(User::EVENT_INIT, 'function_name', 'abc');

        $model = User::findOne(1);
//        VarDumper::dump($model);
//        die;

        return $this->render('say', [
            'message' => $message,
            'model' => $model
            ]);
    }
    function function_name($event) {
        echo $event->data;
    }

    public function actionEntryFrom()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('entry-confirm', [
                'model' => $model
            ]);
        } else {
            return $this->render('entry', [
                'model' => $model
            ]);
        }
    }
}
