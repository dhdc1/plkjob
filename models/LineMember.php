<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "line_member".
 *
 * @property int $id
 * @property string $dep_id
 * @property string $line_id
 * @property string $is_active
 */
class LineMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'line_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'string'],
            [['dep_id', 'line_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'dep_id' => 'แผนก',
            'line_id' => 'ไลน์ไอดี',
            'is_active' => 'สถานะ',
        ];
    }
}
