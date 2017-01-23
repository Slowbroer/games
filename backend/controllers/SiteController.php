<?php
namespace backend\controllers;

use backend\models\ConfigureForm;
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
        $array = [
            ['prize_cost','100',"text"],
            ['prize_cost_type','1',"text"],
            ['point_field','jf',"text"],
            ['point_to_money','100',"text"],
            ['web_name','奇迹mu',"text"],
        ];
//        $config = new Systemconfig();
//        var_dump($config->attributes);
//        foreach ($array as $key => $value)
//        {
//            $config = new Systemconfig();
//            $config->key = $array[$key][0];
//            $config->value = $array[$key][1];
//            $config->type = $array[$key][2];
//            $config->save();
//        }
        Yii::$app->language = 'zh-CN';  //指定使用哪个语言翻译  如果用俄文则是 Yii::$app->language = 'ru';
        echo Yii::t("Systemconfig",'prize_cost');
    }


}
