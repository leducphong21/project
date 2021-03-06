<?php

namespace common\models\project;

use common\models\project\ModelProject;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "m_portion".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $project_id
 * @property integer $deleted
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Portion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_portion';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','acreage','location'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 8],
            ['name','required','message' => 'Tên lô đất không được để trống'],
            ['project_id','required','message' => 'Dự án không được để trống'],
            ['acreage','required','message' => 'Diện tích không được để trống'],
            ['location','required','message' => 'Vị trí không được để trống'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên lô đất',
            'code' => 'Mã',
            'project_id' => 'Dự án',
            'acreage'=> 'Diện tích',
            'location'=> 'Vị trí',
            'deleted' => 'Deleted',
            'created_by' => 'Người tạo',
            'created_at' => 'Ngày tạo',
            'updated_by' => 'Người sửa',
            'updated_at' => 'Ngày sửa',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\project\query\PortionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\project\query\PortionQuery(get_called_class());
    }
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getProject()
    {
        return $this->hasOne(ModelProject::className(), ['id' => 'project_id']);
    }
}
