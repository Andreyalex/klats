<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/25/14
 * Time: 12:45 AM
 */

namespace app\models;

use Imagine\Exception\InvalidArgumentException;
use Imagine\Exception\RuntimeException;
use Imagine\Image\ManipulatorInterface;
use yii\base\InvalidValueException;
use yii\base\Model;
use yii\imagine\Image as ImageExt;
use Imagine\Image\Point;
use Imagine\Image\Box;
use yii\web\UploadedFile;

/**
 * Class Challenge
 * @package app\models
 *
 * @property $id
 * @property $userId
 * @property $urlFull
 * @property $urlSquare
 * @property $urlPreview
 */
class Image extends Model
{
    public static $pathBase = 'web/media';

    public static $urlBase = '/media';

    public static $types = [
        'full'    => [1200, 800, ManipulatorInterface::THUMBNAIL_INSET],
        'preview' => [300,  200, ManipulatorInterface::THUMBNAIL_INSET],
        'square'  => [100,  100, ManipulatorInterface::THUMBNAIL_OUTBOUND],
    ];

    public $id;

    public $userId;

    public $file;

    public $urlFull;

    public $urlSquare;

    public $urlPreview;

    public function upload($model, $field)
    {
        $this->userId = \Yii::$app->user->id;
        $this->id = self::createId($this->userId);

        $uploader = UploadedFile::getInstance($model, $field);
        $base = self::getBasePath($this->userId);
        $ext = $uploader->getExtension();
        $fileName = $base . '/' . $this->createName($this->id, null, $ext);

        if (!is_dir($base) && !mkdir($base, 0777, true)) {
            throw new RuntimeException('Cannot create directory '.$base);
        }

        if (!$uploader->saveAs($fileName)) {
            throw new RuntimeException('Unknown upload error');
        }

        $this->file = $fileName;
    }

    public function save()
    {
        $ext = strtolower(self::getExtension($this->file));

        foreach(self::$types as $type => $conf) {
            $img = ImageExt::thumbnail($this->file, $conf[0], $conf[1], $conf[2]);
            $type == 'square' && ($img = $img->crop(new Point(0, 0), new Box($conf[0], $conf[1])));
            $img->save($this->getBasePath($this->userId) . '/' . $this->createName($this->id, $type, $ext), ['quality' => 90]);
        }

        $this->setAttributes($this->getProperties($this->id), false);
        return $this;
    }

    public static function findOne($id)
    {
        $img = new self;
        $img->setAttributes(self::getProperties($id), false);
        return $img;
    }

    public static function getProperties($id)
    {
        $props = [
            'userId' => null,
            'id' => null,
            'urlPreview' => null,
            'urlFull' => null,
            'urlSquare' => null
        ];

        if (empty($id)) {
            return $props;
        }

        list($userId, $null) = explode('_', $id);

        $url = self::getBaseUrl($userId);

        $props = [
            'userId' => $userId,
            'id' => $id
        ];

        foreach(glob(self::getBasePath($userId).'/'.$id.'_*') as $file) {

            $matches = array();
            $name = array_pop(explode('/', $file));
            preg_match('/_(full|preview|square)\.([a-z]+)/', $name, $matches);
            if (empty($matches[1])) {
                throw new InvalidValueException('Image '.$name.' has unknown type');
            }

            $type = ucfirst($matches[1]);
            $props['url'.$type] = $url . '/' . $name;
        }

        return $props;
    }

    public static function createId($userId)
    {
        return $userId . '_' . rand(100000, 999999);
    }

    public static function createName($id, $type, $extension)
    {
        return $id . ($type? '_'.$type : '') . '.' . $extension;
    }

    /**
     * @deprecated
     *
     * @param $file
     * @return array
     * @throws \Imagine\Exception\InvalidArgumentException
     */
    public static function parseName($file)
    {
        $matches = array();
        if (!preg_match('|([0-9]+)_([0-9]+)_([a-z]+)\.([a-z]+)|', $file, $matches)) {
            throw new InvalidArgumentException('Invalid image file name.');
        }

        return [
            'userId' => $matches[0],
            'id'     => $matches[0] . '_' . $matches[1],
            'type'   => $matches[2],
            'ext'    => $matches[3]
        ];
    }

    public static function getBasePath($userId = null)
    {
        return \Yii::$app->basePath . '/' . self::$pathBase . ($userId? '/' . $userId : '');
    }

    public static function getBaseUrl($userId = null)
    {
        return \Yii::$app->request->baseUrl . self::$urlBase . ($userId? '/' . $userId : '');
    }

    public static function getExtension($file)
    {
        $parts = explode('.', $file);
        return strtolower(array_pop($parts));
    }

//    public function rules()
//    {
//        return [
//            ['id', 'number'],
//            ['userId', 'number'],
//            ['urlFull', 'string'],
//            ['urlPreview', 'string'],
//            ['urlSquare', 'string']
//        ];
//    }
}