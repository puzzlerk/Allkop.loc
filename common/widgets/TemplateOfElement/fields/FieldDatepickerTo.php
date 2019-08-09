<?php
/**
 * User: Vladimir Baranov <phpnt@yandex.ru>
 * Git: <https://github.com/phpnt>
 * VK: <https://vk.com/phpnt>
 * Date: 02.02.2019
 * Time: 17:10
 */

namespace common\widgets\TemplateOfElement\fields;

use phpnt\bootstrapSelect\BootstrapSelectAsset;
use phpnt\datepicker\BootstrapDatepickerAsset;
use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class FieldDatepickerTo extends InputWidget
{
    public $modelFieldForm;
    public $data_id;

    public $options = [];

    public $datapickerOptions   = [];

    public $widgetContainerId;

    public $calendarIcon = "<span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>";

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

        $value = isset($this->model->elements_fields[$this->modelFieldForm->id][1]) ? $this->model->elements_fields[$this->modelFieldForm->id][1] : $fieldsManage->getValue($this->modelFieldForm->id, $this->modelFieldForm->type, $this->model->id);

        if (is_array($value)) {
            $value = $value[1];
        }

        $options = [
            'id' => 'field-' . $this->data_id,
            'name' => $formName . "[elements_fields][$fieldID][1]",
            'value' => $value,
        ];

        $this->options = ArrayHelper::merge($this->options, $options);

        $this->field->label(Yii::t('app', $this->modelFieldForm->name));

        if (isset($this->model->errors_fields[$this->modelFieldForm->id][1])) {
            $error = $this->model->errors_fields[$this->modelFieldForm->id][1];
            $view = $this->getView();
            $view->registerJs('addError("#group-' .  $this->data_id . '-1", "' . $error . '");');
        }

        echo "<div class='input-group date'>";
        echo Html::activeInput('text', $this->model, $this->attribute, $this->options);
        echo $this->calendarIcon;
        echo "</div>";
    }

    public function registerScript()
    {
        $view = $this->getView();
        BootstrapSelectAsset::register($view);
        $asset = BootstrapDatepickerAsset::register($view);

        if ($this->datapickerOptions['language'] != 'en') {
            $view->registerJsFile($asset->baseUrl.'/js/locales/bootstrap-datepicker.' . $this->datapickerOptions['language'] . '.js',
                ['depends' => [\yii\web\JqueryAsset::className()]]);
        }

        $this->datapickerOptions = Json::encode($this->datapickerOptions);

        $js = <<< JS
        $(document).ready(function(){
            $("#$this->idItem").selectpicker({}); 
            $("#$this->widgetContainerId .input-group.date").datepicker($this->datapickerOptions);   
        });
JS;
        $view->registerJs($js);
    }
}