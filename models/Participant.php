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
 * Class Participant
 * @package app\models
 *
 * @property $id
 * @property $userId
 * @property $challengeId
 * @property $createdDate
 */
class Participant extends ActiveRecord
{
    use Crud;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'participant';
    }
}