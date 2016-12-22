<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Guild".
 *
 * @property string $G_Name
 * @property resource $G_Mark
 * @property integer $G_Score
 * @property string $G_Master
 * @property integer $G_Count
 * @property string $G_Notice
 * @property integer $Number
 * @property integer $G_Type
 * @property integer $G_Rival
 * @property integer $G_Union
 * @property integer $MemberCount
 */
class Guild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Guild';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['G_Name'], 'required'],
            [['G_Name', 'G_Mark', 'G_Master', 'G_Notice'], 'string'],
            [['G_Score', 'G_Count', 'G_Type', 'G_Rival', 'G_Union', 'MemberCount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'G_Name' => 'G  Name',
            'G_Mark' => 'G  Mark',
            'G_Score' => 'G  Score',
            'G_Master' => 'G  Master',
            'G_Count' => 'G  Count',
            'G_Notice' => 'G  Notice',
            'Number' => 'Number',
            'G_Type' => 'G  Type',
            'G_Rival' => 'G  Rival',
            'G_Union' => 'G  Union',
            'MemberCount' => 'Member Count',
        ];
    }
}
