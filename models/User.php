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
 * Class User
 * @package app\models
 *
 * @property $id
 * @property $login
 * @property $password
 * @property $name
 * @property $createdDate
 * @property $updatedDate
 */
class User extends ActiveRecord
{
    use Crud;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'user';
    }
}