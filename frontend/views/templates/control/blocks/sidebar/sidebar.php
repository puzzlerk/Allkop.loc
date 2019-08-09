<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 22.01.2019
 * Time: 12:21
 */

use yii\widgets\Menu;
use frontend\views\templates\control\blocks\sidebar\assets\SidebarAsset;

/* @var $this \yii\web\View */
/* @var $page array Главная страница меню */
/* @var $modelSearch \common\models\search\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $itemsMenu array Элементы меню */
/* @var $modelDocumentForm \common\models\forms\DocumentForm Выбранный элемент */
/* @var $tree array Дерево элемента */
/* @var $templateName string */

SidebarAsset::register($this);
?>
<div class="block-sidebar">
    <div class="col-xs-12 m-b-md">
        <div class="menu-<?= $templateName; ?>">
            <div class="sidebar-nav">
                <?= Menu::widget([
                    'items' => $itemsMenu,
                    'options' => [
                        'class' => 'side-menu metismenu',
                    ],
                    'activeCssClass'=>'active',
                ]); ?>
            </div>
        </div>
    </div>
</div>

