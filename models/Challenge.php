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

/**
 * Class Challenge
 * @package app\models
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $createdDate
 * @property $userId
 * @property $isPublic
 *
 * Relations:
 * @property $solutions
 *
 */
class Challenge extends ActiveRecord
{
    use Crud;

    const IS_PRIVATE = 0;
    const IS_PUBLIC = 1;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'challenge';
    }

    /**
     * Gets latest public challenges
     *
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findPublicLatest($limit = 0)
    {
        return self::find()
            ->where(['isPublic' => self::IS_PUBLIC])
            ->orderBy('createdDate DESC')
            ->limit($limit)
            ->all();
    }

    /**
     * @return static
     */
    public function getParticipants()
    {
        return $this
            ->hasMany(User::className(), ['id' => 'userId'])
            ->viaTable('participant', ['challengeId' => 'id']);
    }

    /**
     * Gets latest challenges which user's challenges
     *
     * @param int $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findByOwner($userId)
    {
        return self::find()
            ->where(['userId' => $userId])
            ->orderBy('createdDate DESC')
            ->limit(!empty($options['limit'])? $options['limit'] : 0)
            ->all();
    }

    /**
     * @return static
     */
    public function getSolutions()
    {
        return $this->hasMany(Solution::className(), ['challengeId' => 'id']);
    }

}