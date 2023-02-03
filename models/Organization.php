<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $institution_name
 * @property string|null $organization_type
 * @property string $kra_pin_number
 * @property string $physical_address
 * @property string $email_address
 * @property string $postal_address
 * @property string $phone_number
 * @property int $registered_by
 * @property string $request_letter
 * @property string $aor_appointment_letter
 * @property string $registration_charter_agreement
 * @property string $date_registered
 *
 * @property Letter[] $letters
 * @property User $registeredBy
 * @property User[] $users
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_name', 'kra_pin_number', 'physical_address', 'email_address', 'postal_address', 'phone_number', 'registered_by', 'request_letter', 'aor_appointment_letter', 'registration_charter_agreement'], 'required'],
            [['organization_type'], 'string'],
            [['registered_by'], 'integer'],
            [['date_registered'], 'safe'],
            [['institution_name'], 'string', 'max' => 250],
            [['kra_pin_number'], 'string', 'max' => 11],
            [['physical_address', 'request_letter', 'aor_appointment_letter', 'registration_charter_agreement'], 'string', 'max' => 200],
            [['email_address'], 'string', 'max' => 60],
            [['postal_address'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 50],
            [['kra_pin_number'], 'unique'],
            [['registered_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['registered_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'institution_name' => 'Institution Name',
            'organization_type' => 'Organization Type',
            'kra_pin_number' => 'Kra Pin Number',
            'physical_address' => 'Physical Address',
            'email_address' => 'Email Address',
            'postal_address' => 'Postal Address',
            'phone_number' => 'Phone Number',
            'registered_by' => 'Registered By',
            'request_letter' => 'Request Letter',
            'aor_appointment_letter' => 'Aor Appointment Letter',
            'registration_charter_agreement' => 'Registration Charter Agreement',
            'date_registered' => 'Date Registered',
        ];
    }

    /**
     * Gets query for [[Letters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLetters()
    {
        return $this->hasMany(Letter::class, ['organization_id' => 'id']);
    }

    /**
     * Gets query for [[RegisteredBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredBy()
    {
        return $this->hasOne(User::class, ['id' => 'registered_by']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['organization_id' => 'id']);
    }
}
