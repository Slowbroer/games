<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "GameServerInfo".
 *
 * @property integer $Number
 * @property integer $ItemCount
 * @property integer $ZenCount
 * @property integer $AceItemCount
 * @property integer $GmItemCount
 */
class GameServerInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GameServerInfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Number', 'ItemCount', 'ZenCount', 'AceItemCount', 'GmItemCount'], 'integer'],
            [['ItemCount'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Number' => 'Number',
            'ItemCount' => 'Item Count',
            'ZenCount' => 'Zen Count',
            'AceItemCount' => 'Ace Item Count',
            'GmItemCount' => 'Gm Item Count',
        ];
    }
}
