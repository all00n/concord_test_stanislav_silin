<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property int $group_id
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Groups $group
 *
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['login', 'password', 'email', 'group_id'], 'required'],
            [['created_at', 'updated_at','group_id'], 'safe'],
            [['login', 'password', 'email', 'photo'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'User ID',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'group_id' => 'Group',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }

    public function getGroupName(){
        return $this->group->name;
    }

    public function upload($user_id)
    {
        if ($this->validate()) {
             $this->imageFile->saveAs('uploads/users_photo/' . $user_id . '.' . $this->imageFile->extension);
             return 'uploads/users_photo/' . $user_id . '.' . $this->imageFile->extension;
        }
        return false;

    }
    public function beforeSave($insert) {

        $this->password = md5($this->password);

        return true;

    }
}
