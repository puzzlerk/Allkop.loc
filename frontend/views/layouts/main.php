<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 19.08.2018
 * Time: 8:43
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use phpnt\bootstrapNotify\BootstrapNotify;
use yii\widgets\Pjax;
use common\widgets\MainMenu\MainMenu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= MainMenu::widget([]) ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= BootstrapNotify::widget() ?>
        <div id="main-body-container">
            <?= $content ?>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left"><i class="far fa-copyright"></i> <?= Html::a('phpnt.com', 'http://phpnt.com/', ['target' => '_blank']) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php Pjax::begin(['id' => 'pjaxModalUniversal']); ?><?php Pjax::end(); ?>
<?php Pjax::begin(['id' => 'pjaxModalUniversal2']); ?><?php Pjax::end(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
