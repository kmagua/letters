<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "letter".
 *
 * @property int $id
 * @property int $organization_id
 * @property string $date
 * @property string $reference_number
 * @property string $title
 * @property string $date_received
 * @property string $letter
 * @property int $response_required
 * @property string|null $response_letter
 * @property string|null $status
 * @property string $date_created
 * @property string $last_modified
 *
 * @property Organization $organization
 */
class Letter extends \yii\db\ActiveRecord
{
    public $letter_upload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'letter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'date', 'reference_number', 'title', 'date_received', 'letter', 'response_required'], 'required'],
            [['organization_id', 'response_required'], 'integer'],
            [['date', 'date_received', 'date_created', 'last_modified'], 'safe'],
            [['reference_number'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 500],
            [['letter', 'response_letter'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 100],
            [['letter_upload'], 'file', 'skipOnEmpty' => true, 'extensions' => ['pdf'] , 'maxSize'=> 1024*1024*5],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization',
            'date' => 'Letter Date',
            'reference_number' => 'Reference Number',
            'title' => 'Title (Desctiption)',
            'date_received' => 'Date Received at ICTA',
            'letter' => 'Letter',
            'response_required' => 'Response Required?',
            'response_letter' => 'Response Letter',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }
    
    /**
     * 
     * @return boolean
     */
    public function saveWithFile()
    {
        $this->letter_upload = \yii\web\UploadedFile::getInstance($this, 'letter_upload');        
        if($this->letter_upload){
            $this->letter = 'uploads/letters/' . $this->letter_upload->name . '-' . microtime() .
                '.' . $this->letter_upload->extension;
        }
        if($this->save()){
            ($this->letter_upload)? $this->letter_upload->saveAs($this->letter):null;
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param type $insert
     * @param type $changedAttributes
     * @return boolean
     */
    public function afterSave($insert, $changedAttributes) 
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $la = new LetterAction();
            $la->action_type = 1;
            $la->action_date =  date('Y-m-d');
            $la->done_by = Yii::$app->user->identity->id;
            $la->save(false);
        }        
        return true;
    }
}
