<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 24.09.2018
 * Time: 5:21
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use phpnt\ICheck\ICheck;
use common\models\Constants;
use phpnt\datepicker\BootstrapDatepicker;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelFieldForm \common\models\forms\FieldForm */
?>
<div id="elements-form-block">
    <?php $form = ActiveForm::begin([
        'id' => 'form',
        'action' => $modelFieldForm->isNewRecord ? Url::to(['field-manage/create-field', 'template_id' => $modelFieldForm->template_id]) : Url::to(['field-manage/update-field', 'template_id' => $modelFieldForm->template_id, 'id' => $modelFieldForm->id]),
        'options' => ['data-pjax' => true]
    ]); ?>

    <div class="col-xs-6">
        <?= $form->field($modelFieldForm, 'name')
            ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('name')]) ?>
    </div>

    <div class="col-xs-6">
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?= $form->field($modelFieldForm, 'type')->dropDownList($modelFieldForm->getTypeList(),
                [
                    'class'  => 'form-control selectpicker',
                    'data' => [
                        'style' => 'btn-default',
                        'live-search' => 'false',
                        'title' => '---',
                        'size' => 10
                    ],
                    'onchange' => '
                        $.pjax({
                            type: "POST", 
                            url: "'.Url::to(['field-manage/refresh-field-form']).'",
                            data: $("#form").serializeArray(),
                            container: "#elements-form-block",
                            push: false,
                            timeout: 10000,
                            scrollTo: false
                        });
                '
                ]) ?>
        <?php else: ?>
            <?= $form->field($modelFieldForm, 'type')->dropDownList($modelFieldForm->getTypeList(),
                [
                    'class'  => 'form-control selectpicker disabled',
                    'disabled' => true,
                ]) ?>

        <?php endif; ?>
    </div>

    <?php if ($modelFieldForm->isNewRecord): ?>
        <?php $modelFieldForm->error_value = Yii::t('app', "Поле «{name}» должно быть числом от {min_val} до {max_val}."); ?>
        <?php $modelFieldForm->error_length = Yii::t('app', "Поле «{name}» должно содержать от {min_str} до {max_str} символов."); ?>
        <?php $modelFieldForm->error_required = Yii::t('app', "Поле «{name}» обязательно для заполнения."); ?>
        <?php $modelFieldForm->error_unique = Yii::t('app', "Поле «{name}» должно быть уникально."); ?>
    <?php endif; ?>
    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_INT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_INT_RANGE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_NUM): ?>
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?php $modelFieldForm->min_val = -2147483648; ?>
            <?php $modelFieldForm->max_val = 2147483647; ?>
            <?php $modelFieldForm->min_str = 0; ?>
            <?php $modelFieldForm->max_str = 10; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_DISCOUNT): ?>
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?php $modelFieldForm->min_val = 0; ?>
            <?php $modelFieldForm->max_val = 100; ?>
            <?php $modelFieldForm->min_str = 0; ?>
            <?php $modelFieldForm->max_str = 3; ?>
            <?php $modelFieldForm->is_required = 1; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_FLOAT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_FLOAT_RANGE): ?>
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?php $modelFieldForm->min_str = 0; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_STRING): ?>
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?php $modelFieldForm->min_str = 0; ?>
            <?php $modelFieldForm->max_str = 255; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_FILE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_FEW_FILES): ?>
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?php $modelFieldForm->min_val = 0; ?>
            <?php $modelFieldForm->max_val = 5242880; ?>
            <?php $modelFieldForm->min_str = 0; ?>
            <?php $modelFieldForm->max_str = 5; ?>
            <?php $modelFieldForm->error_value = Yii::t('app', 'Размер файла должен быть от {min_val} до {max_val} байт.'); ?>
            <?php $modelFieldForm->error_length = Yii::t('app', 'Количество файлов должно быль от {min_str} до {max_str} штук.'); ?>
            <?php $modelFieldForm->error_required = Yii::t('app', "Поле «{name}» обязательно для заполнения."); ?>
            <?php $modelFieldForm->error_unique = Yii::t('app', "Поле «{name}» должно быть уникально."); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_DATE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_DATE_RANGE): ?>
        <?php if ($modelFieldForm->isNewRecord): ?>
            <?php $modelFieldForm->error_value = Yii::t('app', "Поле «{name}» должно быть от {min_val} до {max_val}."); ?>
            <?php $modelFieldForm->error_required = Yii::t('app', "Поле «{name}» обязательно для заполнения."); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_INT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_FLOAT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_NUM): ?>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_val')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_val')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_value')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_value')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_str')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_str')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_length')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_length')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_unique', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_unique')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_unique')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_PRICE): ?>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_val')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_val')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_value')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_value')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_DISCOUNT): ?>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'min_val')
                ->hiddenInput()->label(false) ?>
            <?= $form->field($modelFieldForm, 'max_val')
                ->hiddenInput()->label(false) ?>
            <?= $form->field($modelFieldForm, 'min_str')
                ->hiddenInput()->label(false) ?>
            <?= $form->field($modelFieldForm, 'max_str')
                ->hiddenInput()->label(false) ?>
            <?= $form->field($modelFieldForm, 'is_required')
                ->hiddenInput()->label(false) ?>
            <p><?= Yii::t('app', 'Только для раздела "Акции/скидки."') ?></p>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_INT_RANGE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_FLOAT_RANGE): ?>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_val')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_val')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_value')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_value')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_str')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_str')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_length')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_length')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_STRING): ?>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_str')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_str')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_length')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_length')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_unique', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_unique')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_unique')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_TEXT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_EMAIL ||
        $modelFieldForm->type == Constants::FIELD_TYPE_URL ||
        $modelFieldForm->type == Constants::FIELD_TYPE_SOCIAL ||
        $modelFieldForm->type == Constants::FIELD_TYPE_YOUTUBE
    ): ?>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_unique', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_unique')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_unique')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_CHECKBOX ||
        $modelFieldForm->type == Constants::FIELD_TYPE_RADIO ||
        $modelFieldForm->type == Constants::FIELD_TYPE_LIST ||
        $modelFieldForm->type == Constants::FIELD_TYPE_LIST_MULTY): ?>
        <div class="col-xs-12">
            <h4><?= Yii::t('app', 'Значения') ?></h4>
            <div class="list-wrapper">
                <?php if (empty($modelFieldForm->list)) : ?>
                    <?= $form->field($modelFieldForm, 'item', [
                        'options' => ['class' => 'form-group list-item'],
                        'template' =>  '
                            <div class="input-group control-group after-add-more">
                                {input}
                                <div class="input-group-btn">
                                    <button class="btn btn-success add-item" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <i>{hint}</i>
                            {error}'])
                        ->textInput([
                            'id' => 'fieldform-item-0',
                            'name' => 'FieldForm[list][0]',
                        ]) ?>
                <?php else : ?>
                    <?php $i = 0; ?>
                    <?php foreach ($modelFieldForm->list as $item): ?>
                        <?php
                        if ($i == 0) {
                            $button = '<button class="btn btn-success add-item" type="button"><i class="fa fa-plus"></i></button>';
                        } else {
                            $button = '<button class="btn btn-danger remove-item" type="button"><i class="fa fa-times"></i></button>';
                        }
                        ?>
                        <div class="form-group list-item field-fieldform-item-<?= $i ?>">
                            <div class="input-group control-group after-add-more">
                                <input type="text" value="<?= $item ?>" id="fieldform-item-<?= $i ?>" class="form-control" name="FieldForm[list][<?= $i ?>]">
                                <div class="input-group-btn"><?= $button ?></div>
                            </div>
                            <i></i>
                            <p class="help-block help-block-error"></p>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <div class="clearfix"></div>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_DATE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_DATE_RANGE): ?>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'input_date_from')->widget(BootstrapDatepicker::class, [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy',
                'language'  => Yii::$app->language
            ]); ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'input_date_to')->widget(BootstrapDatepicker::class, [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy',
                'language'  => Yii::$app->language
            ]); ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_value')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_value')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_ADDRESS ||
        $modelFieldForm->type == Constants::FIELD_TYPE_CITY ||
        $modelFieldForm->type == Constants::FIELD_TYPE_REGION ||
        $modelFieldForm->type == Constants::FIELD_TYPE_COUNTRY ||
        $modelFieldForm->type == Constants::FIELD_TYPE_DOC
    ): ?>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_FILE): ?>
        <div class="col-xs-12">
            <?php $modelFieldForm->file_extensions = $modelFieldForm->getFileExtValues(); ?>
            <?= $form->field($modelFieldForm, 'file_extensions')->dropDownList($modelFieldForm->getFileExtList(),
                [
                    'class'  => 'form-control selectpicker',
                    'multiple' => 'true',
                    'data' => [
                        'style' => 'btn-default',
                        'live-search' => 'false',
                        'title' => '---',
                        'size' => 10
                    ]
                ])->hint('<i>'.Yii::t('app', Yii::t('app', 'Если не указано ни одного раширения, доступны для загрузки все.')).'</i>') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_val')])
                ->label(Yii::t('app', 'Минимальное числовое значение (байт)')) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_val')])
                ->label(Yii::t('app', 'Максимальное числовое значение (байт)'))?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_value')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_value')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_FEW_FILES): ?>
        <div class="col-xs-12">
            <?php $modelFieldForm->file_extensions = $modelFieldForm->getFileExtValues(); ?>
            <?= $form->field($modelFieldForm, 'file_extensions')->dropDownList($modelFieldForm->getFileExtList(),
                [
                    'class'  => 'form-control selectpicker',
                    'multiple' => 'true',
                    'data' => [
                        'style' => 'btn-default',
                        'live-search' => 'false',
                        'title' => '---',
                        'size' => 10
                    ]
                ])->hint('<i>'.Yii::t('app', Yii::t('app', 'Если не указано ни одного раширения, доступны для загрузки все.')).'</i>') ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_val')])
                ->label(Yii::t('app', 'Минимальное числовое значение (байт)')) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_val')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_val')])
                ->label(Yii::t('app', 'Максимальное числовое значение (байт)'))?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_value')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_value')]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'min_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('min_str')])
                ->label(Yii::t('app', 'Минимальное количество файлов')) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($modelFieldForm, 'max_str')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('max_str')])
                ->label(Yii::t('app', 'Максимальное количество файлов')) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_length')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_length')]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'is_required', ['template' => '{label} {input}'])->widget(ICheck::class, [
                'type'  => ICheck::TYPE_CHECBOX,
                'style'  => ICheck::STYLE_FLAT,
                'color'  => 'blue'                  // цвет
            ])->label(false) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'error_required')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('error_required')]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type): ?>
        <div class="col-xs-12">
            <?= $form->field($modelFieldForm, 'hint')
                ->textInput(['placeholder' => $modelFieldForm->getAttributeLabel('hint')])
                ->hint('<i>' . Yii::t('app', 'Отображение подсказки для поля, аналогочно этой, или др. настройкам.' . '</i>'))
            ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($modelFieldForm, 'position')->dropDownList($modelFieldForm->positionsList,
                [
                    'class'  => 'form-control selectpicker',
                    'data' => [
                        'style' => 'btn-default',
                        'live-search' => 'false',
                        'title' => '---'
                    ]
                ]) ?>
        </div>
    <?php endif; ?>

    <?php if ($modelFieldForm->type == Constants::FIELD_TYPE_INT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_CHECKBOX ||
        $modelFieldForm->type == Constants::FIELD_TYPE_LIST_MULTY ||
        $modelFieldForm->type == Constants::FIELD_TYPE_RADIO ||
        $modelFieldForm->type == Constants::FIELD_TYPE_LIST ||
        $modelFieldForm->type == Constants::FIELD_TYPE_DATE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_FLOAT ||
        $modelFieldForm->type == Constants::FIELD_TYPE_STRING ||
        $modelFieldForm->type == Constants::FIELD_TYPE_PRICE ||
        $modelFieldForm->type == Constants::FIELD_TYPE_CITY ||
        $modelFieldForm->type == Constants::FIELD_TYPE_REGION ||
        $modelFieldForm->type == Constants::FIELD_TYPE_COUNTRY
    ): ?>
        <?php if (isset($modelFieldForm->template) && $modelFieldForm->template->use_filter): ?>
            <div class="col-xs-12">
                <?php if ($modelFieldForm->isNewRecord): ?>
                    <?php $modelFieldForm->use_filter = '1'; ?>
                <?php endif; ?>
                <?= $form->field($modelFieldForm, 'use_filter', ['template' => '{label} {input}'])->widget(ICheck::class, [
                    'type'  => ICheck::TYPE_CHECBOX,
                    'style'  => ICheck::STYLE_FLAT,
                    'color'  => 'blue', // цвет
                    'options' => [
                        'checked' => $modelFieldForm->use_filter
                    ]
                ])->label(false) ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="col-md-12">
        <?= $form->field($modelFieldForm, 'template_id')->hiddenInput([])->error(false)->label(false) ?>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary text-uppercase']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $url_refresh = Url::to(['/document/field-manage/refresh-fields', 'template_id' => $modelFieldForm->template_id]);
    $id_grid_refresh = '#field_of_template_' . $modelFieldForm->template_id;
    $id_collapse = '#field-row-' . $modelFieldForm->template_id .'-collapse1';

    $js = <<< JS
        $('.selectpicker').selectpicker({});
        $('#form').on('beforeSubmit', function () { 
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
                        $("$id_collapse").addClass("in");
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
