<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/25/14
 * Time: 12:45 AM
 */

namespace app\models\forms;

use app\models\Image;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class Challenge
 * @package app\models\forms
 *
 * @property $id
 * @property $title
 * @property $upload
 * @property $description
 * @property $createdDate
 * @property $userId
 * @property $isPublic
 *
 * Relations:
 * @property $solutions
 * @property $image
 *
 */
class Challenge extends \app\models\Challenge
{
    public function rules()
    {
        return [
            ['id', 'number'],
            ['title', 'string'],
            ['file', 'image'],
            ['description', 'string'],
            ['description', 'required'],
            ['userId', 'number'],
            ['isPublic', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'file' => 'Фото',
            'description' => 'Описание',
            'isPublic' => 'Доступно всем'
        ];
    }

    public function beforeSave($insert)
    {
        if (!empty($_FILES['Challenge']['name']['file'])) {
            $img = new Image;
            $img->upload($this, 'file');
            $img->save();
            $this->imageId = $img->id;
        }
        return parent::beforeSave($insert);
    }
}