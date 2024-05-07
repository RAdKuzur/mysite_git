<?php

namespace app\commands;

use app\commands\Generator_helpers\DocHelper;
use app\models\common\Company;
use app\models\common\DocumentIn;
use app\models\common\InOutDocs;
use app\models\common\People;
use app\models\common\Position;
use app\models\common\User;
use app\models\components\FileWizard;
use app\models\null\UserNull;
use app\models\work\UserWork;
use Yii;
use ZipStream\File;

use Arhitector\Yandex\Disk;

class TestDocumentInWork extends DocumentIn
{
    public $signedString;
    public $getString;

    public $scanFile;
    public $docFiles;
    public $applicationFiles;

    public $dateAnswer;
    public $nameAnswer;

    public function __construct(
        $local_number, $local_date, $real_number, $real_date,
        $SecondRandomKey, $ThirdRandomKey
    ){
        $this->local_number = $local_number;
        $this->local_date = $local_date;
        $this->real_number = $real_number;
        $this->real_date = $real_date;
        $this->correspondent_id = 1;
        $this->company_id = 1;
        $this->position_id = 1;
        $this->send_method_id = 2;
        //$this->register_id = 1;
        $this->document_theme = DocHelper::$array_theme[$SecondRandomKey];

        $this->key_words = DocHelper::$array_keywords[$ThirdRandomKey];
        parent::__construct();
    }
    public function rules()
    {
        return [
            [['scanFile'], 'file', 'extensions' => 'png, jpg, pdf, zip, rar, 7z, tag', 'skipOnEmpty' => true],
            [['docFiles'], 'file', 'extensions' => 'xls, xlsx, doc, docx, zip, rar, 7z, tag', 'skipOnEmpty' => true, 'maxFiles' => 10],
            [['applicationFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'ppt, pptx, xls, xlsx, pdf, png, jpg, doc, docx, zip, rar, 7z, tag', 'maxFiles' => 10],

            [['signedString', 'getString'], 'string', 'message' => 'Введите корректные ФИО'],
            [['dateAnswer', 'nameAnswer'], 'string'],
            [['local_date', 'real_date', 'send_method_id', 'position_id', 'company_id', 'document_theme', 'signed_id', 'target', 'get_id', 'creator_id', 'last_edit_id'], 'required'],
            [['local_number', 'position_id', 'company_id', 'signed_id', 'get_id', 'creator_id', 'last_edit_id', 'correspondent_id', 'local_postfix'], 'integer'],
            [['needAnswer'], 'boolean'],
            [['local_date', 'real_date'], 'safe'],
            [['document_theme', 'target', 'scan', 'applications', 'key_words', 'real_number'], 'string', 'max' => 1000],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['get_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['get_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['last_edit_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_edit_id' => 'id']],
            [['signed_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['signed_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'local_number' => '№ п/п',
            'local_date' => 'Дата поступления документа',
            'real_number' => 'Регистрационный номер входящего документа ',
            'real_date' => 'Дата входящего документа ',
            'position_id' => 'Должность',
            'company_id' => 'Организация',
            'document_theme' => 'Тема документа',
            'signed_id' => 'Кем подписан',
            'target' => 'Кому адресован',
            'get_id' => 'Кем получен',
            'scan' => 'Скан',
            'applications' => 'Приложения',
            'creator_id' => 'Регистратор карточки',
            'last_edit_id' => 'Последний редактор карточки',
            'key_words' => 'Ключевые слова',
            'needAnswer' => 'Требуется ответ'
        ];
    }

    //-----------------------------------

    public function getCreatorWork()
    {
        $try = $this->hasOne(UserWork::className(), ['id' => 'creator_id']);
        return $try->all() ? $try : new UserNull();
    }

    public function getLastEditWork()
    {
        $try = $this->hasOne(UserWork::className(), ['id' => 'last_edit_id']);
        return $try->all() ? $try : new UserNull();
    }


    public function uploadScanFile()
    {
        //var_dump($this->scanFile);

        $path = '@app/upload/files/document-in/scan/';
        $date = $this->local_date;
        $new_date = '';
        $filename = '';
        for ($i = 0; $i < strlen($date); ++$i)
            if ($date[$i] != '-')
                $new_date = $new_date.$date[$i];
        if ($this->company->short_name !== '')
        {
            $filename = 'Вх.'.$new_date.'_'.$this->local_number.'_'.$this->company->short_name.'_'.$this->document_theme;
        }
        else
        {
            $filename = 'Вх.'.$new_date.'_'.$this->local_number.'_'.$this->company->name.'_'.$this->document_theme;
        }
        $res = mb_ereg_replace('[ ]{1,}', '_', $filename);
        $res = mb_ereg_replace('[^а-яА-Я0-9._]{1}', '', $res);
        $res = FileWizard::CutFilename($res);
        $this->scan = $res.'.'.$this->scanFile->extension;

        $this->scanFile->saveAs( $path.$res.'.'.$this->scanFile->extension);
    }

    public function uploadApplicationFiles($upd = null)
    {
        $path = '@app/upload/files/document-in/apps/';
        $result = '';
        $counter = 0;
        if (strlen($this->doc) > 4)
            $counter = count(explode(" ", $this->applications)) - 1;
        foreach ($this->applicationFiles as $file) {
            $counter++;
            $date = $this->local_date;
            $new_date = '';
            for ($i = 0; $i < strlen($date); ++$i)
                if ($date[$i] != '-')
                    $new_date = $new_date.$date[$i];
            if ($this->company->short_name !== '')
            {
                $filename = 'Приложение'.$counter.'_Вх.'.$new_date.'_'.$this->local_number.'_'.$this->company->short_name.'_'.$this->document_theme;
            }
            else
            {
                $filename = 'Приложение'.$counter.'_Вх.'.$new_date.'_'.$this->local_number.'_'.$this->company->name.'_'.$this->document_theme;
            }
            $res = mb_ereg_replace('[ ]{1,}', '_', $filename);
            $res = mb_ereg_replace('[^а-яА-Я0-9._]{1}', '', $res);
            $res = FileWizard::CutFilename($res);

            $file->saveAs($path . $res . '.' . $file->extension);
            $result = $result.$res . '.' . $file->extension.' ';
        }
        if ($upd == null)
            $this->applications = $result;
        else
            $this->applications = $this->applications.$result;
        return true;
    }

    public function uploadDocFiles($upd = null)
    {
        $path = '@app/upload/files/document-in/docs/';
        $result = '';
        $counter = 0;
        if (strlen($this->doc) > 4)
            $counter = count(explode(" ", $this->doc)) - 1;
        foreach ($this->docFiles as $file) {
            $counter++;
            $date = $this->local_date;
            $new_date = '';
            for ($i = 0; $i < strlen($date); ++$i)
                if ($date[$i] != '-')
                    $new_date = $new_date.$date[$i];
            if ($this->company->short_name !== '')
            {
                $filename = 'Ред'.$counter.'_Вх.'.$new_date.'_'.$this->local_number.'_'.$this->company->short_name.'_'.$this->document_theme;
            }
            else
            {
                $filename = 'Ред'.$counter.'_Вх.'.$new_date.'_'.$this->local_number.'_'.$this->company->name.'_'.$this->document_theme;
            }
            $res = mb_ereg_replace('[ ]{1,}', '_', $filename);
            $res = mb_ereg_replace('[^а-яА-Я0-9._]{1}', '', $res);
            $res = FileWizard::CutFilename($res);
            $file->saveAs($path . $res . '.' . $file->extension);
            $result = $result.$res . '.' . $file->extension.' ';
        }
        if ($upd == null)
            $this->doc = $result;
        else
            $this->doc = $this->doc.$result;
        return true;
    }

    //-----------------------------------



    public function getDocumentNumber()
    {
        $docs = DocumentIn::find()->orderBy(['local_date' => SORT_DESC])->all();
        if (date('Y') !== substr($docs[0]->local_date, 0, 4))
            $this->local_number = 1;
        else
        {
            $docs = DocumentIn::find()->where(['like', 'local_date', date('Y')])->orderBy(['local_number' => SORT_ASC, 'local_postfix' => SORT_ASC])->all();
            if (end($docs)->local_date > $this->local_date && $this->document_theme != 'Резерв')
            {
                $tempId = 0;
                $tempPre = 0;
                if (count($docs) == 0)
                    $tempId = 1;
                for ($i = count($docs) - 1; $i >= 0; $i--)
                {
                    if ($docs[$i]->local_date <= $this->local_date)
                    {
                        $tempId = $docs[$i]->local_number;
                        if ($docs[$i]->local_postfix != null)
                            $tempPre = $docs[$i]->local_postfix + 1;
                        else
                            $tempPre = 1;
                        break;
                    }
                }

                $this->local_number = $tempId;
                $this->local_postfix = $tempPre;
                Yii::$app->session->addFlash('warning', 'Добавленный документ должен был быть зарегистрирован раньше. Номер документа: '.$this->local_number.'/'.$this->local_postfix);
            }
            else
            {
                if (count($docs) == 0)
                    $this->local_number = 1;
                else
                {
                    $this->local_number = end($docs)->local_number + 1;
                }
            }
        }

    }


    public function beforeDelete()
    {
        $links = InOutDocs::find()->where(['document_in_id' => $this->id])->all();
        foreach ($links as $linkOne)
        {
            $linkOne->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
}
