<?php

namespace common\models;

use Yii;
use common\models\MEMBINFO;
use backend\models\ClassSet;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Character".
 *
 * @property string $AccountID
 * @property string $Name
 * @property integer $cLevel
 * @property integer $LevelUpPoint
 * @property integer $Class
 * @property integer $Experience
 * @property integer $Strength
 * @property integer $Dexterity
 * @property integer $Vitality
 * @property integer $Energy
 * @property resource $Inventory
 * @property resource $MagicList
 * @property integer $Money
 * @property double $Life
 * @property double $MaxLife
 * @property double $Mana
 * @property double $MaxMana
 * @property integer $MapNumber
 * @property integer $MapPosX
 * @property integer $MapPosY
 * @property integer $MapDir
 * @property integer $PkCount
 * @property integer $PkLevel
 * @property integer $PkTime
 * @property string $MDate
 * @property string $LDate
 * @property integer $CtlCode
 * @property integer $DbVersion
 * @property resource $Quest
 * @property integer $Leadership
 * @property integer $ChatLimitTime
 * @property integer $FruitPoint
 * @property integer $ZY
 * @property integer $FQBZ
 * @property integer $FQCount
 * @property string $FQName
 * @property string $JHDX
 * @property integer $JHindex
 * @property integer $JHtype
 * @property integer $CSPOINT
 * @property integer $ZSJP
 * @property integer $MFHY
 * @property integer $LINZB
 * @property string $XDTIME
 * @property string $STOPINFO
 * @property string $STOPTIME
 * @property integer $MFXD
 * @property integer $ResetLife
 * @property integer $JfTopointNum
 * @property string $RestTime
 * @property integer $CampType
 * @property string $CampName
 * @property integer $HonorsValue
 * @property string $NameType
 * @property integer $RewardMaxNum
 */
class Character extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Character';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AccountID', 'Name'], 'required'],
            [['AccountID', 'Name', 'Inventory', 'MagicList', 'Quest', 'FQName', 'JHDX', 'STOPINFO', 'CampName', 'NameType'], 'string'],
            [['cLevel', 'LevelUpPoint', 'Class', 'Experience', 'Strength', 'Dexterity', 'Vitality', 'Energy', 'Money', 'MapNumber', 'MapPosX', 'MapPosY', 'MapDir', 'PkCount', 'PkLevel', 'PkTime', 'CtlCode', 'DbVersion', 'Leadership', 'ChatLimitTime', 'FruitPoint', 'ZY', 'FQBZ', 'FQCount', 'JHindex', 'JHtype', 'CSPOINT', 'ZSJP', 'MFHY', 'LINZB', 'MFXD', 'ResetLife', 'JfTopointNum', 'CampType', 'HonorsValue', 'RewardMaxNum'], 'integer'],
            [['Life', 'MaxLife', 'Mana', 'MaxMana'], 'number'],
            [['MDate', 'LDate', 'XDTIME', 'STOPTIME', 'RestTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AccountID' => 'Account ID',
            'Name' => 'Name',
            'cLevel' => 'C Level',
            'LevelUpPoint' => 'Level Up Point',
            'Class' => 'Class',
            'Experience' => 'Experience',
            'Strength' => 'Strength',
            'Dexterity' => 'Dexterity',
            'Vitality' => 'Vitality',
            'Energy' => 'Energy',
            'Inventory' => 'Inventory',
            'MagicList' => 'Magic List',
            'Money' => 'Money',
            'Life' => 'Life',
            'MaxLife' => 'Max Life',
            'Mana' => 'Mana',
            'MaxMana' => 'Max Mana',
            'MapNumber' => 'Map Number',
            'MapPosX' => 'Map Pos X',
            'MapPosY' => 'Map Pos Y',
            'MapDir' => 'Map Dir',
            'PkCount' => 'Pk Count',
            'PkLevel' => 'Pk Level',
            'PkTime' => 'Pk Time',
            'MDate' => 'Mdate',
            'LDate' => 'Ldate',
            'CtlCode' => 'Ctl Code',
            'DbVersion' => 'Db Version',
            'Quest' => 'Quest',
            'Leadership' => 'Leadership',
            'ChatLimitTime' => 'Chat Limit Time',
            'FruitPoint' => 'Fruit Point',
            'ZY' => 'Zy',
            'FQBZ' => 'Fqbz',
            'FQCount' => 'Fqcount',
            'FQName' => 'Fqname',
            'JHDX' => 'Jhdx',
            'JHindex' => 'Jhindex',
            'JHtype' => 'Jhtype',
            'CSPOINT' => 'Cspoint',
            'ZSJP' => 'Zsjp',
            'MFHY' => 'Mfhy',
            'LINZB' => 'Linzb',
            'XDTIME' => 'Xdtime',
            'STOPINFO' => 'Stopinfo',
            'STOPTIME' => 'Stoptime',
            'MFXD' => 'Mfxd',
            'ResetLife' => 'Reset Life',
            'JfTopointNum' => 'Jf Topoint Num',
            'RestTime' => 'Rest Time',
            'CampType' => 'Camp Type',
            'CampName' => 'Camp Name',
            'HonorsValue' => 'Honors Value',
            'NameType' => 'Name Type',
            'RewardMaxNum' => 'Reward Max Num',
        ];
    }

    public function getMEMBINFO()
    {
        return $this->hasOne(MEMBINFO::className(), ['memb___id' => 'AccountID']);
    }

    public function home_rank($number=10)
    {
        $class = new ClassSet();//职业名称表
        $class_list = $class->get_list();
        $class_array = ArrayHelper::map($class_list,"class_id","class_name");

        $lists = $this->find()->select("Name,cLevel,Class,ZY,PkLevel")->limit($number)->orderBy("cLevel")->asArray()->all();
        foreach($lists as $key=>$list)
        {
            $lists[$key]['ZY_name'] = $class_array[$list['Class']];
            $lists[$key]["PK_name"] = ($list['PkLevel'] > 3)?(($list['PkLevel'] > 5)?"魔头":"恶人"):'义士';
        }
        return $lists;

    }


}
