<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "letter_action".
 *
 * @property int $id
 * @property int $action_type
 * @property string $action_date
 * @property int $done_by
 * @property string|null $comment
 * @property string $date_created
 *
 * @property LetterActionType $actionType
 * @property User $doneBy
 */
class LetterAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'letter_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_type', 'action_date', 'done_by'], 'required'],
            [['action_type', 'done_by'], 'integer'],
            [['action_date', 'date_created'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['action_type'], 'exist', 'skipOnError' => true, 'targetClass' => LetterActionType::class, 'targetAttribute' => ['action_type' => 'id']],
            [['done_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['done_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action_type' => 'Action Type',
            'action_date' => 'Action Date',
            'done_by' => 'Done By',
            'comment' => 'Comment',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * Gets query for [[ActionType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActionType()
    {
        return $this->hasOne(LetterActionType::class, ['id' => 'action_type']);
    }

    /**
     * Gets query for [[DoneBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoneBy()
    {
        return $this->hasOne(User::class, ['id' => 'done_by']);
    }
}
