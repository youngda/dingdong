<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property string $id
 * @property string $ip
 * @property string $get
 * @property string $post
 * @property integer $time
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['ip', 'get', 'post'], 'string'],
            [['time'], 'integer'],
            [['id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'get' => 'Get',
            'post' => 'Post',
            'time' => 'Time',
        ];
    }
}
