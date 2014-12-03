<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/25/14
 * Time: 12:45 AM
 */

namespace app\models\forms;

use yii\base\Model;
/**
 * Class Solution
 * @package app\models\forms
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
class Solution extends \app\models\Solution
{
    public function rules()
    {
        return [
            ['id', 'number'],
            ['title', 'string'],
            ['description', 'string'],
            ['description', 'required'],
            ['userId', 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'description' => 'Описание',
            'isPublic' => 'Доступно всем'
        ];
    }
}