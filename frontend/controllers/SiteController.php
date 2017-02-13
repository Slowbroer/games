<?php
namespace frontend\controllers;

use backend\models\SystemAdmin;
use common\models\Announcement;
use common\models\AnnouncementType;
use common\models\Character;
use common\models\Introduce;
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
use frontend\models\RankForm;

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
        $rank = new Character();
        $rank_list = $rank->home_rank();

        $introduce = new Introduce();
        $introduce_list = $introduce->recent();

        $ann_type = new AnnouncementType();
        $type_lists = $ann_type->ListPreview();
        array_unshift($type_lists,['id'=>0,'name'=>'综合']);

        $ann_lists = array();
        foreach ($type_lists as $key=>$type_list) {
            $ann_lists[] = Announcement::ListPreview($type_list['id']);
        }

//        var_dump(Yii::$app->params['systemConfig']);

        return $this->render('index',[
            'ranks'=>$rank_list,
            'introduces'=>$introduce_list,
            'ann_types'=>$type_lists,
            'ann_lists'=>$ann_lists,
        ]);
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
    public function actionHomeLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return json_encode(array('code'=>1,'message'=>'您已经登陆了，请刷新页面'));
        }
        $memb_id = isset($_POST['username'])? $_POST['username']:'';
        if(empty($memb_id))
        {
            return json_encode(array('code'=>0,'message'=>'请填写用户名'));
        }
        else
        {
            $member = MEMBINFO::findByUsername($memb_id);
            if($member->validatePassword($_POST['password']))
            {
//                if(Yii::$app->user->login($member, $_POST['remember'] ? 3600 * 24 * 30 : 3600*10))
                if(Yii::$app->user->login($member, 3600*10))
                {
                    return json_encode(array('code'=>1,'memb'=>Yii::$app->user->identity->getMenb()));
                }
                else
                {
                    return json_encode(array('code'=>0,'message'=>'登录失败'));
                }
            }
            else
            {
                return json_encode(array('code'=>0,'message'=>'密码和用户名不匹配'));
            }
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
//        $memb = MEMBINFO::findOne(['memb___id'=>'zhang004']);
//        var_dump($memb->memb__pwd);
//        $admin = SystemAdmin::findOne(['admin_name'=>'admin']);
//        $admin->password = md5("123456");
//        $admin->save();
//        echo $this->render("index2");
        $sql = "SELECT * FROM WEB_INF ";
        $connect = Yii::$app->db;
        $command = $connect->createCommand($sql);
        $command->query();


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
