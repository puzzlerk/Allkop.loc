<?php
/**
 * Created by PhpStorm.
 * User: Баранов Владимир <phpnt@yandex.ru>
 * Date: 18.08.2018
 * Time: 19:25
 */

namespace common\models\extend;

use common\models\forms\ValueFileForm;
use common\models\forms\ValuePriceForm;
use Yii;
use common\models\Constants;
use common\models\Field;
use common\models\forms\TemplateForm;
use common\models\forms\ValueIntForm;
use common\models\forms\ValueNumericForm;
use common\models\forms\ValueStringForm;
use common\models\forms\ValueTextForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/*
 * @property array $typeList
 * @property array $typeItem
 * @property array $fileExtList
 * @property array $fileExtItem
 * @property array $fileExtValues
 * @property string $city
 * @property string $region
 * @property string $country
 * @property array $positionsList
 *
 * @property TemplateForm $template
 * @property ValueFileForm[] $valueFiles
 * @property ValueIntForm[] $valueInts
 * @property ValueNumericForm[] $valueNumerics
 * @property ValuePriceForm[] $valuePrices
 * @property ValueStringForm[] $valueStrings
 * @property ValueStringForm[] $valueStringsOfTemplate
 * @property ValueTextForm[] $valueTexts
 */
class FieldExtend extends Field
{
    /**
     * Возвращает список всех полей текущего шаблона
     * @return array
     */
    public function getPositionsList()
    {
        if ($this->isNewRecord) {
            $fields = (new \yii\db\Query())
                ->select(['*'])
                ->from('field')
                ->where([
                    'template_id' => $this->template_id,
                ])
                ->orderBy(['position' => SORT_ASC])
                ->all();
        } else {
            $fields = (new \yii\db\Query())
                ->select(['*'])
                ->from('field')
                ->where([
                    'template_id' => $this->template_id,
                ])
                ->andWhere(['!=', 'id', $this->id])
                ->orderBy(['position' => SORT_ASC])
                ->all();
        }

        return ArrayHelper::map($fields, 'id', 'name');
    }

    /**
     * Возвращает массив выбранных расширений для файлов
     * @return array
     */
    public function getFileExtValues()
    {
        $params = Json::decode($this->params);
        return $params['file_extensions'];
    }
    /**
     * Возвращает город
     *
     * @return string
     */
    public function getCity($id_geo_city) {
        if ($id_geo_city) {
            $data = (new \yii\db\Query())
                ->select(['*'])
                ->from('geo_city')
                ->where(['id_geo_city' => $id_geo_city])
                ->one();
            return $data['name_ru'];
        }
        return '';
    }

    /**
     * Возвращает регион
     *
     * @return string
     */
    public function getRegion($id_geo_region) {
        if ($id_geo_region) {
            $data = (new \yii\db\Query())
                ->select(['*'])
                ->from('geo_region')
                ->where(['id_geo_region' => $id_geo_region])
                ->one();
            return $data['name_ru'];
        }
        return '';
    }

    /**
     * Возвращает страну
     *
     * @return string
    */
    public function getCountry($id_geo_country) {
        if ($id_geo_country) {
            $data = (new \yii\db\Query())
                ->select(['*'])
                ->from('geo_country')
                ->where(['id_geo_country' => $id_geo_country])
                ->one();
            return $data['name_ru'];
        }
        return '';
    }

    /**
     * Возвращает массив доступных расширений для файлов
     * @return array
     */
    public function getFileExtList()
    {
        return [
            Constants::FILE_EXT_JPEG =>  'jpeg',
            Constants::FILE_EXT_JPG =>  'jpg',
            Constants::FILE_EXT_PNG =>  'png',
            Constants::FILE_EXT_PSD =>  'psd',
            Constants::FILE_EXT_PDF =>  'pdf',
            Constants::FILE_EXT_DOC =>  'doc',
            Constants::FILE_EXT_DOCX =>  'docx',
            Constants::FILE_EXT_XLS =>  'xls',
            Constants::FILE_EXT_XLSX =>  'xlsx',
            Constants::FILE_EXT_TXT =>  'txt',
            Constants::FILE_EXT_MP3 =>  'mp3',
            Constants::FILE_EXT_WAV =>  'wav',
            Constants::FILE_EXT_AVI =>  'avi',
            Constants::FILE_EXT_MPG =>  'mpg',
            Constants::FILE_EXT_MPEG =>  'mpeg',
            Constants::FILE_EXT_MPEG_4 =>  'mpeg_4',
            Constants::FILE_EXT_DIVX =>  'divx',
            Constants::FILE_EXT_DJVU =>  'djvu',
            Constants::FILE_EXT_FB2 =>  'fb2',
            Constants::FILE_EXT_RAR =>  'rar',
            Constants::FILE_EXT_ZIP =>  'zip',
        ];
    }

    /**
     * Возвращает расширение файла
     *
     * @return string
     */
    public function getFileExtItem($extension = null)
    {
        if (!$extension) {
            $extension = $this->type;
        }

        switch ($extension) {
            case Constants::FILE_EXT_JPEG:
                return $this->fileExtList[Constants::FILE_EXT_JPEG];
                break;
            case Constants::FILE_EXT_JPG:
                return $this->fileExtList[Constants::FILE_EXT_JPG];
                break;
            case Constants::FILE_EXT_PNG:
                return $this->fileExtList[Constants::FILE_EXT_PNG];
                break;
            case Constants::FILE_EXT_PSD:
                return $this->fileExtList[Constants::FILE_EXT_PSD];
                break;
            case Constants::FILE_EXT_PDF:
                return $this->fileExtList[Constants::FILE_EXT_PDF];
                break;
            case Constants::FILE_EXT_DOC:
                return $this->fileExtList[Constants::FILE_EXT_DOC];
                break;
            case Constants::FILE_EXT_DOCX:
                return $this->fileExtList[Constants::FILE_EXT_DOCX];
                break;
            case Constants::FILE_EXT_XLS:
                return $this->fileExtList[Constants::FILE_EXT_XLS];
                break;
            case Constants::FILE_EXT_XLSX:
                return $this->fileExtList[Constants::FILE_EXT_XLSX];
                break;
            case Constants::FILE_EXT_TXT:
                return $this->fileExtList[Constants::FILE_EXT_TXT];
                break;
            case Constants::FILE_EXT_MP3:
                return $this->fileExtList[Constants::FILE_EXT_MP3];
                break;
            case Constants::FILE_EXT_WAV:
                return $this->fileExtList[Constants::FILE_EXT_WAV];
                break;
            case Constants::FILE_EXT_AVI:
                return $this->fileExtList[Constants::FILE_EXT_AVI];
                break;
            case Constants::FILE_EXT_MPG:
                return $this->fileExtList[Constants::FILE_EXT_MPG];
                break;
            case Constants::FILE_EXT_MPEG:
                return $this->fileExtList[Constants::FILE_EXT_MPEG];
                break;
            case Constants::FILE_EXT_MPEG_4:
                return $this->fileExtList[Constants::FILE_EXT_MPEG_4];
                break;
            case Constants::FILE_EXT_DIVX:
                return $this->fileExtList[Constants::FILE_EXT_DIVX];
                break;
            case Constants::FILE_EXT_DJVU:
                return $this->fileExtList[Constants::FILE_EXT_DJVU];
                break;
            case Constants::FILE_EXT_FB2:
                return $this->fileExtList[Constants::FILE_EXT_FB2];
                break;
            case Constants::FILE_EXT_RAR:
                return $this->fileExtList[Constants::FILE_EXT_RAR];
                break;
            case Constants::FILE_EXT_ZIP:
                return $this->fileExtList[Constants::FILE_EXT_ZIP];
                break;
        }
        return false;
    }

    /**
     * Возвращает массив возможных полей
     * @return array
     */
    public function getTypeList()
    {
        return [
            Constants::FIELD_TYPE_INT =>  Yii::t('app', 'Целое число (INT)'),
            Constants::FIELD_TYPE_INT_RANGE =>  Yii::t('app', 'Диапазон целых чисел (INT)'),
            Constants::FIELD_TYPE_FLOAT =>  Yii::t('app', 'Число (DOUBLE)'),
            Constants::FIELD_TYPE_FLOAT_RANGE =>  Yii::t('app', 'Диапазон чисел с дробью (DOUBLE)'),
            Constants::FIELD_TYPE_NUM =>  Yii::t('app', 'Числовое поле (type="number")'),
            Constants::FIELD_TYPE_STRING =>  Yii::t('app', 'Строка (STRING)'),
            Constants::FIELD_TYPE_TEXT =>  Yii::t('app', 'Текст (TEXT)'),
            Constants::FIELD_TYPE_CHECKBOX =>  Yii::t('app', 'Чекбокс'),
            Constants::FIELD_TYPE_RADIO =>  Yii::t('app', 'Радиокнопка'),
            Constants::FIELD_TYPE_LIST =>  Yii::t('app', 'Список'),
            Constants::FIELD_TYPE_LIST_MULTY =>  Yii::t('app', 'Список с мультивыбором'),
            Constants::FIELD_TYPE_PRICE =>  Yii::t('app', 'Цена'),
            Constants::FIELD_TYPE_DISCOUNT =>  Yii::t('app', 'Процент скидки'),
            Constants::FIELD_TYPE_DATE =>  Yii::t('app', 'Дата'),
            Constants::FIELD_TYPE_DATE_RANGE =>  Yii::t('app', 'Диапазон дат'),
            Constants::FIELD_TYPE_ADDRESS =>  Yii::t('app', 'Адрес'),
            Constants::FIELD_TYPE_CITY =>  Yii::t('app', 'Город'),
            Constants::FIELD_TYPE_REGION =>  Yii::t('app', 'Регион'),
            Constants::FIELD_TYPE_COUNTRY =>  Yii::t('app', 'Страна'),
            Constants::FIELD_TYPE_EMAIL =>  Yii::t('app', 'Эл. почта'),
            Constants::FIELD_TYPE_URL =>  Yii::t('app', 'Ссылка'),
            Constants::FIELD_TYPE_SOCIAL =>  Yii::t('app', 'Страница соц. сети'),
            Constants::FIELD_TYPE_YOUTUBE =>  Yii::t('app', 'Видео YouTube'),
            Constants::FIELD_TYPE_FILE =>  Yii::t('app', 'Файл'),
            Constants::FIELD_TYPE_FEW_FILES =>  Yii::t('app', 'Несколько файлов'),
            Constants::FIELD_TYPE_DOC =>  Yii::t('app', 'Связь к документу'),
        ];
    }

    /**
     * Возвращает тип поля
     *
     * @return string
     */
    public function getTypeItem()
    {
        switch ($this->type) {
            case Constants::FIELD_TYPE_INT:
                return $this->typeList[Constants::FIELD_TYPE_INT];
                break;
            case Constants::FIELD_TYPE_INT_RANGE:
                return $this->typeList[Constants::FIELD_TYPE_INT_RANGE];
                break;
            case Constants::FIELD_TYPE_FLOAT:
                return $this->typeList[Constants::FIELD_TYPE_FLOAT];
                break;
            case Constants::FIELD_TYPE_FLOAT_RANGE:
                return $this->typeList[Constants::FIELD_TYPE_FLOAT_RANGE];
                break;
            case Constants::FIELD_TYPE_NUM:
                return $this->typeList[Constants::FIELD_TYPE_NUM];
                break;
            case Constants::FIELD_TYPE_STRING:
                return $this->typeList[Constants::FIELD_TYPE_STRING];
                break;
            case Constants::FIELD_TYPE_TEXT:
                return $this->typeList[Constants::FIELD_TYPE_TEXT];
                break;
            case Constants::FIELD_TYPE_CHECKBOX:
                return $this->typeList[Constants::FIELD_TYPE_CHECKBOX];
                break;
            case Constants::FIELD_TYPE_RADIO:
                return $this->typeList[Constants::FIELD_TYPE_RADIO];
                break;
            case Constants::FIELD_TYPE_LIST:
                return $this->typeList[Constants::FIELD_TYPE_LIST];
                break;
            case Constants::FIELD_TYPE_LIST_MULTY:
                return $this->typeList[Constants::FIELD_TYPE_LIST_MULTY];
                break;
            case Constants::FIELD_TYPE_PRICE:
                return $this->typeList[Constants::FIELD_TYPE_PRICE];
                break;
            case Constants::FIELD_TYPE_DISCOUNT:
                return $this->typeList[Constants::FIELD_TYPE_DISCOUNT];
                break;
            case Constants::FIELD_TYPE_DATE:
                return $this->typeList[Constants::FIELD_TYPE_DATE];
                break;
            case Constants::FIELD_TYPE_DATE_RANGE:
                return $this->typeList[Constants::FIELD_TYPE_DATE_RANGE];
                break;
            case Constants::FIELD_TYPE_ADDRESS:
                return $this->typeList[Constants::FIELD_TYPE_ADDRESS];
                break;
            case Constants::FIELD_TYPE_CITY:
                return $this->typeList[Constants::FIELD_TYPE_CITY];
                break;
            case Constants::FIELD_TYPE_REGION:
                return $this->typeList[Constants::FIELD_TYPE_REGION];
                break;
            case Constants::FIELD_TYPE_COUNTRY:
                return $this->typeList[Constants::FIELD_TYPE_COUNTRY];
                break;
            case Constants::FIELD_TYPE_EMAIL:
                return $this->typeList[Constants::FIELD_TYPE_EMAIL];
                break;
            case Constants::FIELD_TYPE_URL:
                return $this->typeList[Constants::FIELD_TYPE_URL];
                break;
            case Constants::FIELD_TYPE_SOCIAL:
                return $this->typeList[Constants::FIELD_TYPE_SOCIAL];
                break;
            case Constants::FIELD_TYPE_YOUTUBE:
                return $this->typeList[Constants::FIELD_TYPE_YOUTUBE];
                break;
            case Constants::FIELD_TYPE_FILE:
                return $this->typeList[Constants::FIELD_TYPE_FILE];
                break;
            case Constants::FIELD_TYPE_FEW_FILES:
                return $this->typeList[Constants::FIELD_TYPE_FEW_FILES];
                break;
            case Constants::FIELD_TYPE_DOC:
                return $this->typeList[Constants::FIELD_TYPE_DOC];
                break;
        }
        return false;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueStringsOfTemplate()
    {
        return $this->hasMany(ValueStringForm::class, ['field_id' => 'id'])->where(['document_id' => null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(TemplateForm::class, ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueFiles()
    {
        return $this->hasMany(ValueFileForm::class, ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueInts()
    {
        return $this->hasMany(ValueIntForm::class, ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueNumerics()
    {
        return $this->hasMany(ValueNumericForm::class, ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValuePrices()
    {
        return $this->hasMany(ValuePriceForm::class, ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueStrings()
    {
        return $this->hasMany(ValueStringForm::class, ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueTexts()
    {
        return $this->hasMany(ValueTextForm::class, ['field_id' => 'id']);
    }
}