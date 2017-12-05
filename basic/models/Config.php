<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property string $config_name
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['config_name', 'value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'config_name' => 'Config Name',
            'value' => 'Value',
        ];
    }
}
