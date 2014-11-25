<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionShow($id = null, $context = 'html')
    {
        return $this->render(
            "show.$context.php",
            ['model' => User::findOne($id, 'mustExist') ]
        );
    }

    public function actionCreate()
    {
        $user = new User();
        $user->save();
    }

    public function actionDelete($id = null)
    {
        User::delete($id);
    }
}
