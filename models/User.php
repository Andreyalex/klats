<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/25/14
 * Time: 12:45 AM
 */

namespace app\models;

use yii\db\ActiveRecord;
use app\models\traits\Crud;
use \yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 *
 * @property $id
 * @property $login
 * @property $password
 * @property $name
 * @property $createdDate
 * @property $updatedDate
 * @property $authKey
 * @property $accessToken
 */
class User extends ActiveRecord
{
    use Crud;

    public function getMyChallenges()
    {
        return $this->hasMany(Challenge::className(), ['userId' => 'id']);
    }

    public function getTakenChallenges()
    {
        return $this->hasMany(Challenge::className(), ['id' => 'challengeId'])
            ->viaTable('participant', ['userId' => 'id']);
    }

    public function getFriends()
    {
        return $this->hasMany(User::className(), ['id' => 'user2Id'])
            ->viaTable('friend', ['user1Id' => 'id']);
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'user';
    }
}