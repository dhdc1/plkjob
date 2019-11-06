<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c_department".
 *
 * @property string $id
 * @property string $dep
 */
class CDepartment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'c_department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'dep'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'dep' => 'กลุ่มงาน',
        ];
    }
}
