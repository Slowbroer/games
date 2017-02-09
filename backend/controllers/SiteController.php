<?php
namespace backend\controllers;

use backend\models\ConfigureForm;
use backend\models\OrderFilter;
use common\models\ItemLog;
use common\models\Systemconfig;
use Yii;
use yii\db\QueryBuilder;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;


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
                'only'=>['login','error','index','logout'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
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
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    public function actionConfigure(){
        $model = new ConfigureForm();
        if($model->load(Yii::$app->request->post()))
        {

        }
    }
    public function actionLoadConfig()
    {

        $configure = new Systemconfig();
        $lists = $configure->all();

        return $this->render("config_lists",['lists'=>$lists]);
    }
    public function actionUpdateConfig(){
        $id = Yii::$app->request->get("id");
        $value = Yii::$app->request->get("value");
        $config = Systemconfig::findOne(['id'=>$id]);
        if(!empty($config))
        {
            $config->value = $value;
            $result['code'] = $config->save()? 1:0;
        }
        else
        {
            $result['code'] = 0;
        }
        return json_encode($result);
    }
    public function actionSetConfig()
    {
//        $array = [
//            ['prize_cost','100',"text"],
//            ['prize_cost_type','1',"text"],
//            ['point_field','jf',"text"],
//            ['point_to_money','100',"text"],
//            ['web_name','奇迹mu',"text"],
//        ];
        $array = [
//            ['web_url','www.baidu.com','text'],
//            ['web_title','木瓜奇迹','text'],
//            ['web_keywords','网游','text'],
//            ['web_description','网游','text'],
//            ['web_kfqq','网游','text'],
//            ['web_pay_money','人民币','text'],
//            ['web_pay_field','money','text'],//支付字段
//            ['web_pay_url','www.baidu.com','text'],
//            ['web_body','游戏介绍','text'],
            ['qr_code','@web/images/qr_code.png','text'],
        ];
        $config = new Systemconfig();
        var_dump($config->attributes);
        foreach ($array as $key => $value)
        {
            $config = new Systemconfig();
            $config->key = $array[$key][0];
            $config->value = $array[$key][1];
            $config->type = $array[$key][2];
            $config->save();
        }
//        Yii::$app->language = 'zh-CN';  //指定使用哪个语言翻译  如果用俄文则是 Yii::$app->language = 'ru';
//        echo Yii::t("Systemconfig",'prize_cost');
    }

    public function actionOrderManager()//订单管理
    {
        $order_filter = new OrderFilter();
        if($order_filter->load(Yii::$app->request->post()))
        {
            $order_filter->queryOrders();
            return $this->renderPartial("order_list");
        }
        return $this->render("order_manager",['model'=>$order_filter]);
    }

    public function actionOrderAll()
    {
        $order_log = new ItemLog();
        $all = $order_log->lists();

        return $this->renderPartial('order_list',['lists'=>$all['lists'],'page'=>$all['page']]);
    }


}
