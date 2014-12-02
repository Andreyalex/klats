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
    public static function requireOne($condition)
    {
        /** @var self \yii\db\ActiveRecord */
        if (!$res = self::findOne($condition)) {
            throw new NotFound('Item not found');
        }
        return $res;
    }


    public static function deleteById($id)
    {
        self::deleteAll('id = :id', [':id' => (int)$id]);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if (isset($this->createdDate) && empty($this->createdDate)) {
                $this->createdDate = date('Y-m-d H:i:s');
            }
        }

        return parent::beforeSave($insert);
    }
}