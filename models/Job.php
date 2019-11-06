<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use app\models\CDepartment;
use app\models\CJobStatus;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $job_title
 * @property string $job_detail
 * @property string $job_file
 * @property string $send_department
 * @property string $send_officer
 * @property string $job_deadline
 * @property string $line_alert
 * @property string $created_at
 * @property string $updated_at
 * @property string $accepted_at
 * @property string $accepted_by
 * @property string $accepted_officer
 * @property string $status
 * @property string $note
 */
class Job extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public $upload_file;

    public static function tableName() {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['upload_file'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'png,jpg,jpeg,pdf,zip,rar,ppt,pptx,doc,docx,xls,xlsx'],
            [['job_title', 'send_department'], 'required'],
            [['job_detail', 'line_alert'], 'string'],
            [['job_deadline', 'created_at', 'updated_at', 'accepted_at'], 'safe'],
            [['job_title', 'job_file', 'send_department', 'send_officer', 'accepted_by', 'accepted_officer', 'status', 'note'], 'string', 'max' => 255],
        ];
    }

    public function upload() {
        $this->upload_file->saveAs('attach/admin/' . $this->id . "_" . date('YmdHis') . "." . $this->upload_file->extension);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'job_title' => 'เรื่อง',
            'job_detail' => 'รายละเอียด',
            'job_file' => 'ไฟล์แนบ',
            'send_department' => 'กลุ่มงาน',
            'send_officer' => 'ระบุผู้รับมอบหมาย',
            'job_deadline' => 'วันครบกำหนด',
            'line_alert' => 'แจ้งเตือนทางไลน์',
            'created_at' => 'วันที่สั่ง',
            'updated_at' => 'แก้ไขเมื่อ',
            'accepted_at' => 'รับทราบเมื่อ',
            'accepted_by' => 'รับโดย',
            'accepted_officer' => 'รับทราบโดย',
            'status' => 'สถานะ',
            'note' => 'หมายเหตุ',
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

    public function getDepartment() {
        return $this->hasOne(CDepartment::className(), ['id' => 'send_department']);
    }

    public function getJobstatus() {
        return $this->hasOne(CJobStatus::className(), ['id' => 'status']);
    }

}
