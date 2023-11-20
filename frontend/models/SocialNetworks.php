<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "social_networks".
 *
 * @property int $id
 * @property string $name
 * @property string|null $clientId
 * @property string|null $clientSecret
 * @property string|null $username
 * @property string|null $password
 * @property string|null $src
 * @property string $status
 * @property string $updated_at
 */
class SocialNetworks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_networks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'string'],
            [['updated_at'], 'safe'],
            [['name', 'clientId', 'clientSecret', 'username', 'password', 'src'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'clientId' => 'Client ID',
            'clientSecret' => 'Client Secret',
            'username' => 'Username',
            'password' => 'Password',
            'src' => 'Src',
            'status' => 'Status',
            'updated_at' => 'Updated At',
        ];
    }
}
