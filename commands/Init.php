<?php
/**
 * Created by PhpStorm.
 * User: r8
 * Date: 01.03.19
 * Time: 1:40
 */

namespace app\commands;

use Yii;
use yii\helpers\Url;


class Init extends \yii\base\Component {
    public function init() {
        if (\Yii::$app->getUser()->isGuest &&
            \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }

        parent::init();
    }
}