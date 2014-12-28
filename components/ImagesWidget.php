<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12/4/14
 * Time: 11:50 PM
 */

namespace app\components;

use yii\base\Widget;
use yii\web\View;

class ImagesWidget extends Widget
{
    public $urlAdd;

    public $urlDelete;

    public $items;

    public function run()
    {
        \Yii::$app->getView()->registerCssFile('/stuff/yo/images/productimages.css');
        \Yii::$app->getView()->registerJsFile('/stuff/yo/yo.js');
        \Yii::$app->getView()->registerJsFile('/stuff/yo/images/jquery.ui.widget.js');
        \Yii::$app->getView()->registerJsFile('/stuff/yo/images/jquery.iframe-transport.js');
        \Yii::$app->getView()->registerJsFile('/stuff/yo/images/jquery.fileupload.js');
        \Yii::$app->getView()->registerJsFile('/stuff/yo/images/images.js');

        ob_start();
        ?>
        jQuery(function(){
            var images = new yo.widget.images;
            images.init({
                'view': '#piContainer',
                'uploadControl': '#piFileupload',
                'items': <?= json_encode($this->items) ?>,
                'api': {
                    add: '<?= $this->urlAdd ?>',
                    delete: '<?= $this->urlDelete ?>'
                }
            });
        });
        <?php
        \Yii::$app->getView()->registerJs(
            ob_get_clean(),
            View::POS_END
        );
    }
}