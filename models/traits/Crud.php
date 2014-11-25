<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/25/14
 * Time: 12:59 AM
 */

namespace app\models\traits;

use app\models\exceptions\NotFound;


trait Crud
{
    public static function findOne($id, $mustExist = false)
    {
        /** @var self \yii\db\ActiveRecord */
        $row = parent::findOne($id);

        if ($mustExist && $row === null) {
            throw new NotFound(__CLASS__ . ' has no entity with id ' . $id);
        }

        return $row;
    }
}