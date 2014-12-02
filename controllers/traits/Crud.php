<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11/29/14
 * Time: 1:26 PM
 */

namespace app\controllers\traits;

use Yii;
use yii\helpers\Url;

/**
 * Class Crud
 * @package app\controllers\traits
 * @uses app\controllers
 */
trait Crud
{
    public function actionCreate()
    {
        /** @var \yii\db\ActiveRecord $model */
        $class = $this->getCrudForm();
        $model = new $class;
        $request = Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->save()) {
            return $this->afterUpdateItem('create', $model);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit($id)
    {
        /** @var \yii\db\ActiveRecord $model */
        $class = $this->getCrudForm();
        $model = $class::requireOne($id);
        $request = Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->save()) {
            return $this->afterUpdateItem('edit', $model);
        }
        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        /** @var \yii\db\ActiveRecord $model */
        $class = $this->getCrudForm();
        $model = $class::requireOne($id);
        $model->requireOne($id);
        $request = Yii::$app->request;
        if ($request->isPost && $model->load($request->post()) && $model->save()) {
            return $this->afterUpdateItem('delete', $model);
        }
        return $this->render('delete', ['model' => $model]);
    }

    protected function afterUpdateItem($action, $model)
    {
        return $this->redirect(strtolower($this->getCrudName()).'/list');
    }

    protected function getCrudForm()
    {
        return '\\app\\models\\forms\\'.$this->getCrudName();
    }

    protected function getCrudName()
    {
        $parts = explode('\\', __CLASS__);
        return str_replace('Controller', '', array_pop($parts));
    }
}