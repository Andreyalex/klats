<?php

namespace app\controllers;

use Yii;
use app\controllers\traits\Crud;
use app\models\Challenge;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ChallengeController extends Controller
{
    use Crud;

    public function actionShow($id = null)
    {
        return $this->render(
            "show.php",
            ['model' => Challenge::findOne($id) ]
        );
    }


    public function actionDelete($id = null)
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Use post to delete');
        }

        Challenge::deleteAll($id);
    }

    protected function afterUpdateItem($action, $model)
    {
        switch($action) {
            case 'create':
            case 'edit':
                return $this->redirect(Url::to(['/challenge/show', 'id' => $model->id]));
            case 'delete':
                return $this->redirect(Url::to(['/challenge/list']));
        }
    }

}
