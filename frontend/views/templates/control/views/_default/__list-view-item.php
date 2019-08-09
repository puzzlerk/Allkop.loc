<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 22.01.2019
 * Time: 13:29
 */

use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $modelDocumentForm \common\models\forms\DocumentForm */
/* @var $key int */
/* @var $index int */
/* @var $widget \yii\widgets\ListView */
/* @var $templateName string */
/* @var $fieldsManage \common\widgets\TemplateOfElement\components\FieldsManage */
$fieldsManage = Yii::$app->fieldsManage;
$templateData = $fieldsManage->getData($modelDocumentForm->id, $modelDocumentForm->template_id);

$templateName = $modelDocumentForm->template ? $modelDocumentForm->template->mark : 'default';

if ($modelDocumentForm->alias_menu_item ==$modelDocumentForm->parent->alias) {
    $url = Url::to(['/control/default/view', 'alias_menu_item' => $modelDocumentForm->alias_menu_item, 'alias_item' => $modelDocumentForm->alias]);
} else {
    $url = Url::to(['/control/default/view', 'alias_menu_item' => $modelDocumentForm->alias_menu_item, 'alias_sidebar_item' => $modelDocumentForm->parent->alias, 'alias_item' => $modelDocumentForm->alias]);
}
?>
<div class="list-item list-item-<?= $templateName; ?>">
    <?php if ((Yii::$app->request->get('alias_menu_item') == 'basket') && isset($modelDocumentForm->template->templateViewItemBasket) && $modelDocumentForm->template->templateViewItemBasket->view): ?>
        <?= $modelDocumentForm->getDataItemListBasket($url); ?>
    <?php elseif ((Yii::$app->request->get('alias_menu_item') != 'basket') && isset($modelDocumentForm->template->templateViewItemList) && $modelDocumentForm->template->templateViewItemList->view): ?>
        <?= $modelDocumentForm->getDataItemList($url); ?>
    <?php else: ?>
        <div class="col-md-4 m-b-md">
            <?php /* Отображение элемента в списке */ ?>
            <a href="<?= $url ?>" class="item-link">
                <div class="item-card">
                    <div class="text-center p-t-xs">
                        <h5><?= Yii::t('app', $modelDocumentForm->name) ?></h5>
                    </div>
                    <div>
                        <?php if ($modelDocumentForm->template_id): ?>
                            <?php p($templateData) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>
    <?php endif; ?>
</div>