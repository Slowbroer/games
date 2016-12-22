<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%AccountCharacter}}".
 *
 * @property integer $Number
 * @property string $Id
 * @property string $GameID1
 * @property string $GameID2
 * @property string $GameID3
 * @property string $GameID4
 * @property string $GameID5
 * @property string $GameIDC
 * @property integer $MoveCnt
 * @property integer $summoner
 */
class AccountCharacter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%AccountCharacter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id'], 'required'],
            [['Id', 'GameID1', 'GameID2', 'GameID3', 'GameID4', 'GameID5', 'GameIDC'], 'string'],
            [['MoveCnt', 'summoner'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Number' => 'Number',
            'Id' => 'ID',
            'GameID1' => 'Game Id1',
            'GameID2' => 'Game Id2',
            'GameID3' => 'Game Id3',
            'GameID4' => 'Game Id4',
            'GameID5' => 'Game Id5',
            'GameIDC' => 'Game Idc',
            'MoveCnt' => 'Move Cnt',
            'summoner' => 'Summoner',
        ];
    }


}
