<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/11
 * Time: 下午6:24
 */

namespace frontend\models;


use yii\base\Model;
use common\models\MEMBINFO;
use common\models\TzItem;

class PackageForm extends Model
{

    public $id;


    public function rules()
    {
        return [
            [['id'],'integer'],
            ['id','exist','targetClass' => '\common\models\TzItem', 'targetAttribute'=>'Id','message'=>"无效的套装，请刷新后重新选择"]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>"套装",
        ];
    }

    public function buypackage($memb_id){

        $package = TzItem::findOne(['Id'=>$this->id]);
        $memb_info = MEMBINFO::findOne(['memb___id'=>$memb_id]);
        if($memb_info->money<$package->Prise)
        {
            return array('code'=>0,'message'=>"余额不足");
        }



    }




}