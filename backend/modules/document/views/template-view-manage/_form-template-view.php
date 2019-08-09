<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 14.02.2019
 * Time: 14:45
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use phpnt\summernote\SummernoteWidget;
use common\models\Constants;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelTemplateViewForm \common\models\forms\TemplateViewForm */
/* @var $useTemplateFieldsTypes array */

$useTemplateFieldsTypes = $modelTemplateViewForm->useTemplateFieldsTypes;
?>
<div id="elements-form-block">
    <div class="col-sm-7">
        <?php $form = ActiveForm::begin([
            'id' => 'form',
            'action' => Url::to(['/document/template-view-manage/index', 'template_id' => $modelTemplateViewForm->template_id, 'type' => $modelTemplateViewForm->type, 'id' => $modelTemplateViewForm->id]),
            'options' => ['data-pjax' => true]
        ]); ?>
        <?= $form->field($modelTemplateViewForm, 'view')->widget(SummernoteWidget::class,[
            'options' => [
                'id' => 'summernote',
                'class' => 'hidden',
            ],
            'i18n' => true,             // переводить на другие языки
            'codemirror' => true,       // использовать CodeMirror (оформленный редактор кода)
            'emoji' => false,            // включить эмоджи
            'widgetOptions' => [
                /* Настройка панели */
                //'placeholder' => Yii::t('app', 'Введите текст'),
                'height' => 200,
                'tabsize' => 2,
                'minHeight' => 400,
                'maxHeight' => 500,
                //'focus' => true,
                'dialogsInBody' => true,
                'enterHtml' => '',
                /* Панель управления */
                'toolbar' => [
                    ['codeview'],
                ],
                'callbacks' => [
                    'onInit' => new \yii\web\JsExpression(
                        'function (data) {

                        }'
                    ),
                    'onFocus' => new \yii\web\JsExpression(
                        'function (data) {
                            $("div.note-editor .btn-codeview").click(); 
                        }'
                    ),
                ],
            ],
        ]); ?>

        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary text-uppercase']) ?>
            <?php if (!$modelTemplateViewForm->isNewRecord): ?>
                <?= Html::button(Yii::t('app', 'Удалить'), [
                    'class' => 'btn btn-danger text-uppercase',
                    'onclick' => '
                    if (confirm("' . Yii::t('app', 'Удалить') . '?")) {
                        $("#universal-modal").modal("hide");
                        $.pjax({
                            type: "GET",
                            url: "' . Url::to(['/document/template-view-manage/delete', 'template_id' => $modelTemplateViewForm->template_id, 'id' => $modelTemplateViewForm->id]) . '", 
                            container: "#views_of_template_' . $modelTemplateViewForm->template_id . '",
                            push: false,
                            timeout: 10000,
                            scrollTo: false
                        });
                    }'
                ]) ?>
            <?php endif; ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-sm-5">
        <div class="scroll-block m-t-md" style="overflow-x: hidden; padding: 10px; height: 500px; max-height: 500px;">
            <label class="control-label"><?= Yii::t('app', 'Используемые поля.') ?></label>
            <div class="row">
                <?= $modelTemplateViewForm->haveTemplateFields ?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h3><?= Yii::t('app', 'Возможные значения') ?></h3>
                </div>
                <div class="col-sm-6">
                    <label class="control-label"><?= Yii::t('app', 'Для всех используемых полей.') ?></label>
                    <p>
                        <?= Yii::t('app', '<strong>{_ПОЛЕ_}</strong> - вывод названия поля.') ?><br>
                        <?= Yii::t('app', '<strong>{=ПОЛЕ=}</strong> - вывод значения поля.') ?><br>
                    </p>
                    <label class="control-label"><?= Yii::t('app', 'Встроенные поля - "Наименование", "Заголовок", "Алиас", "Аннотация", "Содержание" (без кавычек).') ?></label>
                    <p>
                        <?= Yii::t('app', '<strong>{~_ПОЛЕ_~}</strong> - вывод названия поля.') ?><br>
                        <?= Yii::t('app', '<strong>{~=ПОЛЕ=~}</strong> - вывод значения поля.') ?><br>
                    </p>
                    <label class="control-label"><?= Yii::t('app', 'Встроенные блоки.') ?></label>
                    <p>
                        <?php if ($modelTemplateViewForm->type == Constants::TYPE_ITEM): ?>
                            <?= Yii::t('app', '<strong>{!like!}</strong> - кнопка "Нравиться".') ?><br>
                            <?= Yii::t('app', '<strong>{!like-dislike!}</strong> - кнопки "Нравиться" и "Не нравиться".') ?><br>
                            <?= Yii::t('app', '<strong>{!stars!}</strong> - рейтинг.') ?><br>
                            <?= Yii::t('app', '<strong>{!comments!}</strong> - блок комментариев.') ?><br>
                            <?php if ($modelTemplateViewForm->getHaveTemplateType($useTemplateFieldsTypes, Constants::FIELD_TYPE_PRICE)): ?>
                                <?= Yii::t('app', '<strong>{!+basket+!}</strong> - кнопка в корзину.') ?><br>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($modelTemplateViewForm->type == Constants::TYPE_ITEM_LIST): ?>
                            <?= Yii::t('app', '<strong>{!like!}</strong> - кнопка "Нравиться".') ?><br>
                            <?= Yii::t('app', '<strong>{!like-dislike!}</strong> - кнопки "Нравиться" и "Не нравиться".') ?><br>
                            <?= Yii::t('app', '<strong>{!stars!}</strong> - рейтинг.') ?><br>
                            <?= Yii::t('app', '<strong>{!item-view!}</strong> - ссылка для просмотра элемента.') ?><br>
                            <?php if ($modelTemplateViewForm->getHaveTemplateType($useTemplateFieldsTypes, Constants::FIELD_TYPE_PRICE)): ?>
                                <?= Yii::t('app', '<strong>{!+basket+!}</strong> - кнопка в корзину.') ?><br>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($modelTemplateViewForm->type == Constants::TYPE_ITEM_BASKET): ?>
                            <?php if ($modelTemplateViewForm->getHaveTemplateType($useTemplateFieldsTypes, Constants::FIELD_TYPE_PRICE)): ?>
                                <?= Yii::t('app', '<strong>{!-basket-!}</strong> - удалить из корзины.') ?><br>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-sm-6">
                    <?php if ($modelTemplateViewForm->getHaveTemplateType($useTemplateFieldsTypes, Constants::FIELD_TYPE_PRICE)): ?>
                        <label class="control-label"><?= Yii::t('app', 'Цена.') ?></label>
                        <p>
                            <?= Yii::t('app', '<strong>{$_ПОЛЕ_$}</strong> - название скидки.') ?><br>
                            <?= Yii::t('app', '<strong>{$=ПОЛЕ=$}</strong> - цена без скидки.') ?><br>
                            <?= Yii::t('app', '<strong>{$%ПОЛЕ%$}</strong> - процент скидки.') ?><br>
                            <?= Yii::t('app', '<strong>{$!ПОЛЕ!$}</strong> - дата окончания скидки.') ?><br>
                            <?= Yii::t('app', '<strong>{$#ПОЛЕ#$}</strong> - валюта.') ?><br>
                            <?= Yii::t('app', '<strong>{$~ПОЛЕ~$}</strong> - ассортимент.') ?><br>
                            <?= Yii::t('app', '<strong>{$^ПОЛЕ^$}</strong> - ед. измерения.') ?><br>
                            <?= Yii::t('app', '<strong>{$?ПОЛЕ?$}</strong> - кол-во на складе.') ?><br>
                            <?php if ($modelTemplateViewForm->type == Constants::TYPE_ITEM_BASKET): ?>
                                <?= Yii::t('app', '<strong>{$+ПОЛЕ+$}</strong> - выбрано ассортимента.') ?><br>
                                <?= Yii::t('app', '<strong>{$*ПОЛЕ*$}</strong> - полная стоимость одного товара.') ?><br>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($modelTemplateViewForm->getHaveTemplateType($useTemplateFieldsTypes, Constants::FIELD_TYPE_FILE)): ?>
                        <label class="control-label"><?= Yii::t('app', 'Изображение.') ?></label>
                        <p>
                            <?= Yii::t('app', '<strong>{^_ПОЛЕ_^}</strong> - вывод изображения в блоке.') ?><br>
                            <?= Yii::t('app', '<strong>{^=ПОЛЕ=^}</strong> - вывод изображения в модальном окне.') ?><br>
                            <?= Yii::t('app', '<strong>{^[ПОЛЕ1, ПОЛЕ2, ...]^}</strong> - карусель. Значения ПОЛЕ(N), это один или несколько загруженных файлов (jpg, jpeg, png).') ?><br>
                        </p>
                    <?php endif; ?>
                    <?php if ($modelTemplateViewForm->getHaveTemplateType($useTemplateFieldsTypes, Constants::FIELD_TYPE_YOUTUBE)): ?>
                        <label class="control-label"><?= Yii::t('app', 'Видео YouTube.') ?></label>
                        <p>
                            <?= Yii::t('app', '<strong>{^_ПОЛЕ_^}</strong> - вывод превью.') ?><br>
                            <?= Yii::t('app', '<strong>{^=ПОЛЕ=^}</strong> - вывод видео.') ?><br>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $url_refresh = Url::to(['/document/template-view-manage/refresh-templates', 'template_id' => $modelTemplateViewForm->template_id]);
    $id_grid_refresh = '#views_of_template_' . $modelTemplateViewForm->template_id;

    $js = <<< JS
        $('#form').on('beforeSubmit', function () {
            $("div.note-editor .btn-codeview").click(); 
            var form = $(this);
                $.pjax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: new FormData($('#form')[0]),
                    container: "#elements-form-block",
                    push: false,
                    scrollTo: false,
                    cache: false,
                    contentType: false,
                    timeout: 10000,
                    processData: false
                })
                .done(function(data) {
                    try {
                        var result = jQuery.parseJSON(data);
                    } catch (e) {
                        return false;
                    }
                    if(result.success) {
                        // data is saved
                        console.log('success 2');
                        $("#universal-modal").modal("hide");
                        $.pjax({
                            type: "GET", 
                            url: "$url_refresh",
                            container: "$id_grid_refresh",
                            push: false,
                            timeout: 20000,
                            scrollTo: false
                        });
                    } else if (result.validation) {
                        // server validation failed
                        console.log('validation failed');
                        form.yiiActiveForm('updateMessages', data.validation, true); // renders validation messages at appropriate places
                    } else {
                        // incorrect server response
                        console.log('incorrect server response');
                    }
                })
                .fail(function () {
                    // request failed
                    console.log('request failed');
                })
            return false; // prevent default form submission
        });
JS;
    $this->registerJs($js); ?>
</div>
