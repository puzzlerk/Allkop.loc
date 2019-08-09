<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 07.12.2018
 * Time: 8:41
 */

use frontend\views\templates\control\views\_default\assets\DefaultTempAsset;

/* @var $this \yii\web\View */
/* @var $page array Главная страница меню */
/* @var $modelSearch \common\models\search\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $itemsMenu array Элементы меню */
/* @var $modelDocumentForm \common\models\forms\DocumentForm Выбранный элемент */
/* @var $tree array Дерево элемента */
/* @var $templateName string */

DefaultTempAsset::register($this);
?>
<div class="index-<?= $templateName; ?>">
    <?php if ($itemsMenu): ?>
        <?php /* Если есть элементы бокового меню */ ?>
        <div class="row">
            <div class="block-left">
                <div class="col-md-3">
                    <div class="row">
                        <?= $this->render('@frontend/views/templates/control/blocks/sidebar/sidebar', [
                            'page' => $page,
                            'modelSearch' => $modelSearch,
                            'dataProvider' => $dataProvider,
                            'itemsMenu' => $itemsMenu,
                            'modelDocumentForm' => $modelDocumentForm,
                            'tree' => $tree,
                            'templateName' => $templateName
                        ]); ?>
                        <?php if (($dataProvider->models || Yii::$app->request->get('DocumentSearch')) && isset($modelSearch->template) && $modelSearch->template->use_filter): ?>
                            <?= $this->render('@frontend/views/templates/control/blocks/search/search', [
                                'page' => $page,
                                'modelSearch' => $modelSearch,
                                'dataProvider' => $dataProvider,
                                'itemsMenu' => $itemsMenu,
                                'modelDocumentForm' => $modelDocumentForm,
                                'tree' => $tree,
                                'templateName' => $templateName
                            ]); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="block-right">
                <div class="col-md-9">
                    <div class="row">
                        <?= $this->render('data', [
                            'page' => $page,
                            'modelSearch' => $modelSearch,
                            'dataProvider' => $dataProvider,
                            'itemsMenu' => $itemsMenu,
                            'modelDocumentForm' => $modelDocumentForm,
                            'tree' => $tree,
                            'templateName' => $templateName
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif (($dataProvider->models || Yii::$app->request->get('DocumentSearch')) && (Yii::$app->request->get('alias_menu_item') != 'basket')): ?>
        <?php /* Если есть элементы, но нет бокового меню */ ?>
        <div class="row">
            <?php if (isset($modelSearch->template) && $modelSearch->template->use_filter): ?>
                <div class="block-left">
                    <div class="col-md-3">
                        <div class="row">
                            <?= $this->render('@frontend/views/templates/control/blocks/search/search', [
                                'page' => $page,
                                'modelSearch' => $modelSearch,
                                'dataProvider' => $dataProvider,
                                'itemsMenu' => $itemsMenu,
                                'modelDocumentForm' => $modelDocumentForm,
                                'tree' => $tree,
                                'templateName' => $templateName
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="block-right">
                    <div class="col-md-9">
                        <div class="row">
                            <?= $this->render('data', [
                                'page' => $page,
                                'modelSearch' => $modelSearch,
                                'dataProvider' => $dataProvider,
                                'itemsMenu' => $itemsMenu,
                                'modelDocumentForm' => $modelDocumentForm,
                                'tree' => $tree,
                                'templateName' => $templateName
                            ]); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-12">
                    <div class="row">
                        <?= $this->render('data', [
                            'page' => $page,
                            'modelSearch' => $modelSearch,
                            'dataProvider' => $dataProvider,
                            'itemsMenu' => $itemsMenu,
                            'modelDocumentForm' => $modelDocumentForm,
                            'tree' => $tree,
                            'templateName' => $templateName
                        ]); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ((Yii::$app->request->get('alias_menu_item') == 'basket') && $dataProvider->models): ?>
        <?php /* Если есть элементы, но нет бокового меню */ ?>
        <div class="row">
            <div class="block-left">
                <div class="col-md-9">
                    <div class="row">
                        <?= $this->render('data', [
                            'page' => $page,
                            'modelSearch' => $modelSearch,
                            'dataProvider' => $dataProvider,
                            'itemsMenu' => $itemsMenu,
                            'modelDocumentForm' => $modelDocumentForm,
                            'tree' => $tree,
                            'templateName' => $templateName
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="block-right">
                <div class="col-md-3">
                    <div class="row">
                        <?= $this->render('@frontend/views/templates/control/blocks/payment/form-payment', [
                            'page' => $page,
                            'modelSearch' => $modelSearch,
                            'dataProvider' => $dataProvider,
                            'itemsMenu' => $itemsMenu,
                            'modelDocumentForm' => $modelDocumentForm,
                            'tree' => $tree,
                            'templateName' => $templateName
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php /* Если нет элементов бокового меню */ ?>
            <?= $this->render('data', [
                'page' => $page,
                'modelSearch' => $modelSearch,
                'dataProvider' => $dataProvider,
                'itemsMenu' => $itemsMenu,
                'modelDocumentForm' => $modelDocumentForm,
                'tree' => $tree,
                'templateName' => $templateName
            ]); ?>
        </div>
    <?php endif; ?>
</div>