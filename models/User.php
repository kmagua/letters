<?php

namespace app\models;

use Yii;
use kartik\password\StrengthValidator;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $other_names
 * @property string $designation
 * @property string $id_number
 * @property string $email_address
 * @property string|null $personal_number
 * @property string|null $id_number_upload
 * @property string|null $password
 * @property string|null $role
 * @property int|null $organization_id
 * @property string|null $status
 *
 * @property CodeSigningCertification[] $codeSigningCertifications
 * @property DeviceCertificateApplication[] $deviceCertificateApplications
 * @property HumanSubscriberRequest[] $humanSubscriberRequests
 * @property Organization $organization
 * @property Organization[] $organizations
 * @property TokenLoss[] $tokenLosses
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{    
    public $username;
    public $authKey;
    public $accessToken;
    public $password_repeat;
    public $id_upload;
    public $reCaptcha;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email_address', 'organization_id'], 'required'],
            [['role', 'status'], 'string'],
            [['first_name', 'other_names', 'designation', 'id_number', 'id_number_upload', 'personal_number'], 'required', 'on' => 'edit'],
            [['organization_id'], 'integer'],
            [['first_name', 'personal_number'], 'string', 'max' => 30],
            [['other_names', 'email_address'], 'string', 'max' => 60],
            [['designation'], 'string', 'max' => 100],
            [['id_number'], 'string', 'max' => 20],
            [['id_number_upload'], 'string', 'max' => 200],
            [['password'], 'string', 'max' => 150],
            [['email_address'], 'unique'],
            [['email_address'], 'email'],
            [['reCaptcha'], \kekaadrenalin\recaptcha3\ReCaptchaValidator::className(), 'acceptance_score' => 0.5, 'on' => ['password_reset']],
            [['password'], StrengthValidator::className(), 'min' => 8, 'upper' => 1, 'lower' => 1, 'digit' => 1,
                'special' => 1, 'userAttribute'=>'email_address', 'on'=> ['register', 'change_pwd']],
            [['id_upload'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png','pdf', 'jpg'] , 'maxSize'=> 1024*1024*1],
            [['password_repeat'], 'validatePasswordRepeat', 'on'=>['password_update', 'register_internal']],
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
            'first_name' => 'First Name',
            'other_names' => 'Other Names',
            'designation' => 'Designation',
            'id_number' => 'ID Number',
            'id_upload' => 'ID Upload',
            'email_address' => 'Email Address',
            'personal_number' => 'Personal Number',
            'id_number_upload' => 'Id Number Upload',
            'password' => 'Password',
            'role' => 'Role',
            'password_repeat' => 'Repeat Password',
            'organization_id' => 'Organization ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[CodeSigningCertifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodeSigningCertifications()
    {
        return $this->hasMany(CodeSigningCertification::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[DeviceCertificateApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceCertificateApplications()
    {
        return $this->hasMany(DeviceCertificateApplication::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[HumanSubscriberRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHumanSubscriberRequests()
    {
        return $this->hasMany(HumanSubscriberRequest::class, ['user_id' => 'id']);
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
     * Gets query for [[Organizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::class, ['registered_by' => 'id']);
    }

    /**
     * Gets query for [[TokenLosses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTokenLosses()
    {
        return $this->hasMany(TokenLoss::class, ['user_id' => 'id']);
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $rec = static::findOne(['email_address' => $username]);        
        return $rec;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return "npki" . $this->getId() . "keyfunga";
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }
    
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        //only on new record or password change
        if($insert || $this->scenario == 'password_update'){
            if($insert){
                $this->password = Utility::generateRandomString(30);
            }
            $password_before_hash = $this->password;
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            if(!$this->customPasswordChecks($insert, $password_before_hash)){
                $this->addError('password', 'Password must not match any of the last 3 passwords you have used.');
                return false;
            }
            $this->last_password_change_date = date('Y-m-d 00:00:00');
        }
        return true;
    }
    
    public function afterSave($insert, $changedAttributes) 
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $this->sendUserProfileEmail();
        }
        
        return true;
    }
    
    /**
     * 
     * @return boolean
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->username = $this->email_address;
        $this->authKey = $this->getAuthKey();
        return true;
    }
    
    
    public function getUserName()
    {
        return $this->email_address;
    }
    
    /**
     * 
     * @param type $insert
     * @return boolean
     */
    public function customPasswordChecks($insert, $password_before_hash)
    {
        if($insert){
            $this->recent_passwords = $this->password;           
        }else{
            return $this->passwordDoesNotMatchThreerecent($password_before_hash);
        }
        return true;
    }
    
    /**
     * 
     * @param type $password_before_hash
     * @return boolean
     */
    public function passwordDoesNotMatchThreerecent($password_before_hash)
    {
        $passwords = explode(':::::', ($this->recent_passwords == '')?'':$this->recent_passwords);
        
        foreach($passwords as $old_password){
            if(password_verify($password_before_hash, $old_password)){
                return false;
            }
        }
        if(count($passwords) == 3){
            $this->recent_passwords = $passwords[1] . ':::::' . $passwords[2] . ':::::' . $this->password;
        }else{
            $this->recent_passwords = $this->recent_passwords . ':::::' . $this->password;
        }
        return true;
    }    
    
    /**
     * 
     * @param type $uid
     */
    public static function updateLastLoginTime($uid)
    {
        $sql = "UPDATE user set last_login_date =:time_now WHERE id =:uid ";
        Yii::$app->db->createCommand($sql, [':uid' => $uid, ':time_now' => date('Y-m-d H:i:s')])->execute();
    }
    
    /**
     * Validate password repeat
     */
    public function validatePasswordRepeat($attribute, $params)
    {
        if($this->password != $this->password_repeat){
            $this->addError($attribute, "Passwords do not match!");
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function saveWithFile()
    {
        $this->id_upload = \yii\web\UploadedFile::getInstance($this, 'id_upload');
        if($this->id_upload){
            $this->id_number_upload = 'uploads/ids/' . $this->id_upload->name . '-' . microtime() .
                '.' . $this->id_upload->extension;
        }               
        if($this->save()){
            ($this->id_upload)? $this->id_upload->saveAs($this->id_number_upload):null;            
            return true;
        }
        return false;
    }
    
    public static function getOrgId()
    {
        if(!\Yii::$app->user->isGuest){
            if(isset(Yii::$app->user->identity->organization)){
                return Yii::$app->user->identity->organization->id;
            }
        }
        return 0;
    }
    
    public function isInternal()
    {
        return in_array(strtolower($this->role), ['admin', 'icta']);
    }
    
    /**
     * 
     * @param type $group
     * @return boolean
     */
    public function inGroup($group, $include_adm = false)
    {
        if(!\Yii::$app->user->isGuest){
            $grp = strtolower($group);
            $usr_grp = strtolower(Yii::$app->user->identity->role);
            if($usr_grp == 'admin' && $include_adm == true){
                return true;
            }
            if(in_array($usr_grp, ['aor', 'subscriber']) && Yii::$app->user->identity->status == 'pending-review'){
                return false;
            }
            return $usr_grp == $grp;
        }
        return false;
    }
    
    public function setDefaultValues()
    {
        $role = strtolower(\Yii::$app->user->identity->role);
        if($role == 'admin'){
            $this->role = 'ICTA';
        }else if($role == 'icta'){
            $this->role = 'AOR';
        }else if($role == 'aor'){
            $this->role = 'Subscriber';
        }
    }
    
    public function getName()
    {
        return $this->first_name . ' ' . $this->other_names;
    }
    
    public function getOrgOr($or='designation')
    {
        if($this->organization){
            return $this->organization->institution_name;
        }
        return $this->$or;
    }
    
    public function sendUserProfileEmail()
    {
        $header = "NPKI System Login Credentials";
        
        $link = \yii\helpers\Url::to(['/user/reset-password'], true);
        
        $message = <<<MSG
            Dear {$this->getName()},
            <p>Kindly take note that your account to login to the NPKI portal as below.</p>
            <p><strong>User Name</strong>: {$this->email_address}. Click on the link below to reset your password to allow you to login</p>
            <p>$link</p>
            <p>Thank you,<br>ICT Authority NPKI team.</p>                
MSG;
        Utility::sendMail($this->email_address, $header, $message);
    }
    
    public static function getUserNotification()
    {
        if(!Yii::$app->user->isGuest && 
            !Yii::$app->user->identity->isInternal() && Yii::$app->user->identity->status == 'pending-review'){
            $usr = Yii::getAlias('@web') . '/user/update?id=' .Yii::$app->user->identity->id;
            return '<div class="alert alert-danger alert-dismissable col-lg-12 col-md-12">
                <h6>Your profile is not complete. 
                    Kindly update <a href='. $usr . '>here</a> to allow you submit requests for certificates.</h6>
            </div>';
                    
        }
    }
}
