<?php
namespace frontend\controllers;

use backend\models\SystemAdmin;
use common\models\MEMBINFO;
use common\models\SetServerList;
use common\models\Warehouse;
use frontend\models\ResetPasswordWithOld;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
            $server = new SetServerList();
            $server_list = $server->get_list();
            return $this->render('login', [
                'model' => $model,
                'server_list' => $server_list,
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
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
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
//            die("test");
            if ($user = $model->signup()) {//返回一个MEMBINFO

                $warehouse = new Warehouse();
                $warehouse->register_add($user);

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        $server = new SetServerList();
        $server_list = $server->get_list();


        return $this->render('signup', [
            'model' => $model,
            'server_list' => $server_list,
            'title'=>'注册'
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
            if ($model->sendEmail()) {//这里进行token是否有效的判断
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
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
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionUserinfo()
    {
        if(!Yii::$app->user->isGuest)
        {
            $memb_id = Yii::$app->user->getMenb();
            $memb = MEMBINFO::find()->where(['memb___id'=>$memb_id])->asArray()->one();
            return json_encode($memb);
        }
        else
        {
            $this->redirect(array("site/login"));
        }
    }
    public function actionResetPasswordWithOld()
    {
        if(Yii::$app->user->isGuest)
        {
            $this->redirect(array("site/login"));
        }
        $reset_form = new ResetPasswordWithOld();
        $reset_form->memb_id = Yii::$app->user->identity->getMenb();

        if($reset_form->load(Yii::$app->request->post())&&$reset_form->validate())
        {
            if($reset_form->reset_password())
            {
                echo $this->render("success",['message'=>'修改密码成功！','name'=>'修改密码']);
            }
            else
            {
                echo $this->render("error",['message'=>'修改密码失败！','name'=>'修改密码']);
            }
        }
        else
        {
            echo $this->render("resetPasswordWithOld",['model'=>$reset_form]);
        }
    }



    public function actionTest(){
        $memb = MEMBINFO::findOne(['memb___id'=>'zhang004']);
        var_dump($memb->memb__pwd);
        $admin = SystemAdmin::findOne(['admin_name'=>'admin']);
        $admin->password = md5("123456");
        $admin->save();
    }

    public function actionSqlexe()
    {
//        $sql = "alter table MEMBINFO add  password_reset_token VARCHAR ";
//        $connect = Yii::$app->db;
//        $command = $connect->createCommand();
//        $row = $command->alterColumn('MEMBINFO','password_reset_token','string');
//        $command->execute();
//        $memb = MEMBINFO::findOne(['memb___id'=>'zhang004']);
//        $memb->mail_addr = 'mj1573975217@outlook.com';
//        $memb->save();
//        var_dump(Yii::$app->mailer);
        $mail= Yii::$app->mailer->compose();
        $mail->setTo('mj1573975217@outlook.com');
        $mail->setSubject("邮件测试");

        $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
        if($mail->send())
            echo "success";
        else
            echo "failse";
        die();
    }



}
