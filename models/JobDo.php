<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "job_do".
 *
 * @property int $id
 * @property int $job_id
 * @property string $do_detail
 * @property string $do_file
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class JobDo extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public $upload_file;

    public static function tableName() {
        return 'job_do';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['upload_file'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'png,jpg,jpeg,pdf,zip,rar,ppt,pptx,doc,docx,xls,xlsx'],
            [['job_id'], 'required'],
            [['job_id'], 'integer'],
            [['do_detail'], 'string'],
            [['do_file', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'do_detail' => 'ระบุความก้าวหน้า',
            'do_file' => 'ชื่อไฟล์',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'upload_file' => 'ไฟล์แนบ'
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()')
            ],
            BlameableBehavior::className(),
        ];
    }

    public function upload($job_id) {
        $this->upload_file->saveAs('attach/emp/' . $job_id."_".$this->id . '.' . $this->upload_file->extension);
    }

}
