<?php

namespace app\models\work;

use app\models\common\Auditorium;
use app\models\work\AuditoriumTypeWork;
use app\models\common\Branch;
use app\models\components\FileWizard;
use Yii;
use yii\helpers\Html;


class AuditoriumWork extends Auditorium
{
    public $filesList;


    public function rules()
    {
        return [
            [['name', 'square', 'branch_id'], 'required'],
            [['is_education', 'branch_id', 'capacity', 'auditorium_type_id', 'window_count', 'include_square'], 'integer'],
            [['square'], 'number'],
            [['name', 'text', 'files'], 'string', 'max' => 1000],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => BranchWork::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['auditorium_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuditoriumTypeWork::className(), 'targetAttribute' => ['auditorium_type_id' => 'id']],
            [['filesList'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Уникальный глобальный номер',
            'square' => 'Площадь (кв.м.)',
            'text' => 'Имя',
            'capacity' => 'Кол-во ученико-мест',
            'files' => 'Файлы',
            'filesList' => 'Файлы',
            'is_education' => 'Предназначен для обр. деят.  ',
            'branch_id' => 'Название отдела',
            'include_square' => 'Учитывать при подсчете общей площади',
            'window_count' => 'Количество оконных проемов',
            'auditorium_type_id' => 'Тип помещения',
            'auditoriumTypeString' => 'Тип помещения',
        ];
    }

    public function GetIncludeSquareStr()
    {
        return $this->include_square == 1 ? 'Да' : 'Нет';
    }

    public function GetAuditoriumTypeString()
    {
        return $this->auditoriumTypeWork->name;
    }

    public function GetAuditoriumTypeWork()
    {
        return $this->hasOne(AuditoriumTypeWork::className(), ['id' => 'auditorium_type_id']);
    }

    public function GetFullName()
    {
        return $this->name. ' (' . $this->text. ')' ;
    }

    public function GetIsIncludeSquare()
    {
        return $this->include_square ? 'Да' : 'Нет';
    }

    public function GetIsEducation()
    {
        return $this->is_education ? 'Да' : 'Нет';
    }

    public function GetBranchName()
    {
        return Html::a($this->branch->name, \yii\helpers\Url::to(['branch/view', 'id' => $this->branch_id]));
    }

    public function uploadFiles($upd = null)
    {
        $path = '@app/upload/files/auditorium/';
        $result = '';
        $counter = 0;
        if (strlen($this->files) > 3)
            $counter = count(explode(" ", $this->files)) - 1;
        foreach ($this->filesList as $file) {
            $counter++;
            $filename = 'Файл'.$counter.'_'.$this->name.'_'.$this->id;
            $res = mb_ereg_replace('[ ]{1,}', '_', $filename);
            $res = FileWizard::CutFilename($res);
            $res = mb_ereg_replace('[^а-яА-Я0-9a-zA-Z._]{1}', '', $res);
            $file->saveAs($path . $res . '.' . $file->extension);
            $result = $result.$res . '.' . $file->extension.' ';
        }
        if ($upd == null)
            $this->files = $result;
        else
            $this->files = $this->files.$result;
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        // проверяем учебные группы на ошибку "аудитория не учебная"
        $errorsCheck = new GroupErrorsWork();
        $errorsCheck->CheckAuditoriumTrainingGroup($this->id);
    }

    public function beforeDelete()
    {
        // проверяем учебные группы на ошибку "аудитория не учебная"
        $errorsCheck = new GroupErrorsWork();
        $errorsCheck->CheckAuditoriumTrainingGroup($this->id);

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
}
