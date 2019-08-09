<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 02.02.2019
 * Time: 15:31
 */

namespace common\widgets\TemplateOfElement\fields;

use phpnt\bootstrapSelect\BootstrapSelectAsset;
use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;

class FieldDropdown extends InputWidget
{
    public $modelFieldForm;
    public $data_id;

    public $options = [];

    private $idItem;

    public function init()
    {
        parent::init();
        $fieldID = $this->modelFieldForm->id;
        $this->idItem = 'field-' . $fieldID;
    }

    public function run()
    {
        $this->registerScript();

        /* @var $fieldsManage \common\widgets\TemplateOfElement\components\FieldsManage */
        $fieldsManage = Yii::$app->fieldsManage;

        $formName = $this->model->formName();
        $fieldID = $this->modelFieldForm->id;

        $options = [
            'id' => 'field-' . $this->data_id,
            'name' => $formName . "[elements_fields][$fieldID][0]",
            'value' => isset($this->model->elements_fields[$this->modelFieldForm->id][0]) ? $this->model->elements_fields[$this->modelFieldForm->id][0] : $fieldsManage->getValue($this->modelFieldForm->id, $this->modelFieldForm->type, $this->model->id),
        ];

        $this->options = ArrayHelper::merge($this->options, $options);

        $this->field->label(Yii::t('app', $this->modelFieldForm->name));
        $this->field->hint('<i>' . Yii::t('app', $this->modelFieldForm->hint) . '</i>');

        if (isset($this->model->errors_fields[$this->modelFieldForm->id][0])) {
            $error = $this->model->errors_fields[$this->modelFieldForm->id][0];
            $view = $this->getView();
            $view->registerJs('addError("#group-' .  $this->data_id . '", "' . $error . '");');
        }

        echo Html::activeDropDownList($this->model, $this->attribute, $this->modelFieldForm->list, $this->options);
    }

    public function registerScript()
    {
        $view = $this->getView();
        BootstrapSelectAsset::register($view);

        $js = <<< JS
        $(document).ready(function(){
            $("#$this->idItem").selectpicker({});      
        });
JS;
        $view->registerJs($js);
    }
}