<?php

namespace app\commands\test_models;

use app\commands\Generator_helpers\DocHelper;
use app\models\common\DocumentOrder;
use app\models\common\DocumentOrderSupplement;
use app\models\common\Expire;
use app\models\common\ForeignEventParticipants;
use app\models\common\ParticipantFiles;
use app\models\common\People;
use app\models\common\User;
use app\models\common\Regulation;
use app\models\common\Responsible;
use app\models\components\FileWizard;
use app\models\null\PeopleNull;
use app\models\null\UserNull;
use Psr\Log\NullLogger;
use Yii;
use yii\helpers\Html;
use app\models\components\Logger;
use yii\web\UploadedFile;


class TestDocumentOrderWork extends DocumentOrder
{
    public $scanFile;
    public $docFiles;
    public $responsibles;
    public $expires;
    public $expires2;
    public $people_arr;

    public $signedString;
    public $executorString;
    public $bringString;
    public $creatorString;

    public $allResp;

    public $nomenclature_number;

    public $groups_check;
    public $participants_check;
    public $new_groups_check;

    public $archive_check;

    public $archive_number;

    public $foreign_event;
    public $supplement;
    public $participants;
    public function __construct($real_number, $date,  $FirstRandomKey, $SecondRandomKey, $type){
        $this->order_copy_id = $real_number;
        $this->order_number = '02-02';
        $this->order_name = DocHelper::$array_name[$FirstRandomKey];
        $this->order_date = $date;
        $this->bring_id = 1;
        $this->executor_id = 1;
        $this->register_id = 1;
        $this->type = $type;
        $this->state = 1;
        $this->nomenclature_id = 5;
        $this->key_words = DocHelper::$array_keywords[$SecondRandomKey];

        parent::__construct();
    }


    public function rules()
    {
        return [
            [['scanFile'], 'file', 'extensions' => 'jpg, png, pdf, doc, docx, zip, rar, 7z, tag', 'skipOnEmpty' => true],
            [['docFiles'], 'file', 'extensions' => 'xls, xlsx, doc, docx, zip, rar, 7z, tag', 'skipOnEmpty' => true, 'maxFiles' => 10],
            [['signedString', 'executorString', 'bringString', 'creatorString', 'documentNumberString'], 'string'],
            [['order_number', 'order_name', 'order_date', 'signed_id', 'bring_id', 'executor_id', 'creator_id',
                'signedString', 'executorString', 'bringString'], 'required'],
            [['signed_id', 'bring_id', 'executor_id', 'creator_id', 'last_edit_id', 'order_postfix', 'order_copy_id', 'type', 'nomenclature_id', 'archive_check' ], 'integer'],
            [['order_date', 'allResp', 'groups_check', 'participants_check', 'new_groups_check', 'study_type', 'foreign_event', 'supplement', 'participants'], 'safe'],
            [['state'], 'boolean'],
            [['order_name', 'scan', 'key_words'], 'string', 'max' => 1000],
            [['nomenclature_number', 'archive_number'], 'string'],
            [['order_number'], 'string', 'max' => 100],
            [['bring_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['bring_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['last_edit_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_edit_id' => 'id']],
            [['signed_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['signed_id' => 'id']],
            [['foreign_event'], 'exist', 'skipOnError' => true, 'targetClass' => ForeignEventWork::className(), 'targetAttribute' => ['id' => 'order_participation_id']],
            //[['supplement'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentOrderSupplementWork::className(), 'targetAttribute' => ['id' => 'document_order_id']],
            [['participantsFile'], 'file', 'extensions' => 'jpg, png, pdf, doc, docx, zip, rar, 7z, tag', 'skipOnEmpty' => true],
        ];
    }

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

    public function getChangeDocFile()
    {
        $split = explode(" ", $this->doc);
        $result = '';
        if (count($split) > 1)
            for ($i = 0; $i < count($split); $i++)
                $result = $result.Html::a($split[$i], \yii\helpers\Url::to(['document-order/get-file', 'fileName' => $split[$i], 'modelId' => $this->id, 'type' => 'docs'])).'<br>';
        else
        {
            if ($this->type === 0 || $this->type == 11 || $this->type == 2)   // учебный или об участии
            {
                $view = NomenclatureWork::find()->where(['number' => $this->order_number])->andWhere(['actuality' => 0])->one();
                $result = Html::a("Сгенерировать файл", \yii\helpers\Url::to(['document-order/generation-word', 'order_id' => $this->id, 'type' => $view->type]), ['class'=>'btn btn-success']);
            }
        }
        return $result;
    }


    public function getBringWork()
    {
        $try = $this->hasOne(PeopleWork::className(), ['id' => 'bring_id']);
        return $try->all() ? $try : new PeopleNull();
    }

    public function getGroupsLink()
    {
        $orders = OrderGroupWork::find()->where(['document_order_id' => $this->id])->all();
        $result = '';
        foreach ($orders as $order)
        {
            $result .= Html::a($order->trainingGroup->number, \yii\helpers\Url::to(['training-group/view', 'id' => $order->training_group_id]));
            $result .= '<br>';
        }
        return $result;
    }

    public function getParticipantsLink()
    {
        $pasta = OrderGroupParticipantWork::find()->joinWith(['orderGroup orderGroup'])->where(['orderGroup.document_order_id' => $this->id])->all();
        $flag = 0;
        $result = '';
        foreach ($pasta as $macaroni)
        {
            if ($macaroni->link_id !== NULL)
            {
                $flag = 1;
                break;
            }
            $result .= $macaroni->getParticipantAndGroup();
            $result .= '<br>';
        }

        if ($flag !== 0)
        {
            $result = '';
            foreach ($pasta as $macaroni)
            {
                if ($macaroni->link_id !== NULL)
                {
                    $result .= $macaroni->getParticipantDefectors();
                    $result .= '<br>';
                }
            }
        }

        return $result;
    }

    public function getDocumentNumberString()
    {
        if ($this->order_copy_id == 0)
            return $this->order_number;
        if ($this->order_postfix == null)
            return $this->order_number.'/'.$this->order_copy_id;
        else
            return $this->order_number.'/'.$this->order_copy_id.'/'.$this->order_postfix;
    }

    public function getExpireOrders2()
    {
        $changes = ExpireWork::find()->where(['expire_type' => 2])->andWhere(['active_regulation_id' => $this->id])->andWhere(['not', ['expire_order_id' => null]])->all();
        $result = "";
        foreach ($changes as $change)
        {
            $doc_num = 0;
            if ($change->expireOrderWork->order_postfix == null)
                $doc_num = $change->expireOrderWork->order_number.'/'.$change->expireOrderWork->order_copy_id;
            else
                $doc_num = $change->expireOrderWork->order_number.'/'.$change->expireOrderWork->order_copy_id.'/'.$change->expireOrderWork->order_postfix;
            $result .= Html::a('Приказ №' . $doc_num . ' ' . $change->expireOrderWork->order_name, \yii\helpers\Url::to(['document-order/view', 'id' => $change->expire_order_id])) . '<br>';
        }

        $changes = ExpireWork::find()->where(['expire_type' => 2])->andWhere(['active_regulation_id' => $this->id])->andWhere(['not', ['expire_regulation_id' => null]])->all();
        foreach ($changes as $change)
        {
            $result .= Html::a('Положение ' . $change->expireRegulationWork->name, \yii\helpers\Url::to(['regulation/view', 'id' => $change->expire_regulation_id])) . '<br>';
        }

        return $result;
    }

    public function getChangeDocs()
    {
        $changes = ExpireWork::find()->where(['expire_type' => 2])->andWhere(['expire_order_id' => $this->id])->all();
        $result = "";
        foreach ($changes as $change)
        {
            $doc_num = 0;
            if ($change->activeRegulationWork->order_postfix == null)
                $doc_num = $change->activeRegulationWork->order_number.'/'.$change->activeRegulationWork->order_copy_id;
            else
                $doc_num = $change->activeRegulationWork->order_number.'/'.$change->activeRegulationWork->order_copy_id.'/'.$change->activeRegulationWork->order_postfix;
            $result .= Html::a('Приказ №' . $doc_num . ' ' . $change->activeRegulationWork->order_name, \yii\helpers\Url::to(['document-order/view', 'id' => $change->active_regulation_id])) . '<br>';
        }
        return $result;
    }
    public function uploadScanFile()
    {
        $path = '@app/upload/files/document-order/scan/';
        $date = $this->order_date;
        $new_date = '';
        for ($i = 0; $i < strlen($date); ++$i)
            if ($date[$i] != '-')
                $new_date = $new_date.$date[$i];

        $filename = '';
        if ($this->order_postfix == null)
            $filename = 'П.'.$new_date.'_'.$this->order_number.'-'.$this->order_copy_id.'_'.$this->order_name;
        else
            $filename = 'П.'.$new_date.'_'.$this->order_number.'-'.$this->order_copy_id.'-'.$this->order_postfix.'_'.$this->order_name;
        $res = mb_ereg_replace('[ ]{1,}', '_', $filename);
        $res = mb_ereg_replace('[^а-яА-Я0-9._]{1}', '', $res);
        $res = FileWizard::CutFilename($res);
        $this->scan = $res . '.' . $this->scanFile->extension;
        $this->scanFile->saveAs( $path . $res . '.' . $this->scanFile->extension);

        Logger::WriteLog(Yii::$app->user->identity->getId(), 'Добавлен скан документа ' . $filename . ' в приказ (id=' .$this->id . ')');
    }

    public function uploadDocFiles($upd = null)
    {
        $path = '@app/upload/files/document-order/docs/';
        $result = '';
        $counter = 0;
        if (strlen($this->doc) > 4)
            $counter = count(explode(" ", $this->doc)) - 1;
        foreach ($this->docFiles as $file) {
            $counter++;
            $date = $this->order_date;
            $new_date = '';
            for ($i = 0; $i < strlen($date); ++$i)
                if ($date[$i] != '-')
                    $new_date = $new_date.$date[$i];
            $filename = '';
            if ($this->order_postfix == null)
                $filename = $counter.'_Пр.'.$new_date.'_'.$this->order_number.'-'.$this->order_copy_id.'_'.$this->order_name;
            else
                $filename = $counter.'_Пр.'.$new_date.'_'.$this->order_number.'-'.$this->order_copy_id.'-'.$this->order_postfix.'_'.$this->order_name;
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

        Logger::WriteLog(Yii::$app->user->identity->getId(), 'Добавлен редактируемый документ ' . $filename . ' в приказ (id=' .$this->id . ')');

        return true;
    }

    private function uploadTeamName($foreign_event_id)
    {
        $teamName = [];
        $teamNameException = [];

        $teamNameaExisting = TeamNameWork::find()->where(['foreign_event_id' => $foreign_event_id])->all();
        foreach ($teamNameaExisting as $one)
            $teamNameException[] = $one->name;

        foreach ($this->participants as $partOne)
            if (!in_array($partOne->team, $teamName) && !in_array($partOne->team, $teamNameException) && $partOne->team != NULL && $partOne->team != '--' && $partOne->team != 'NULL')
                $teamName[] = $partOne->team;

        foreach ($teamName as $oneTeam)
        {
            $team = new TeamNameWork();
            $team->name = $oneTeam;
            $team->foreign_event_id = $foreign_event_id;
            $team->save();
        }
    }

    private function cleanArrParticipant($foreign_event_id)
    {
        $arrPart = [];
        $partsBD = TeacherParticipantWork::find()->where(['foreign_event_id' => $foreign_event_id])->all();

        foreach ($this->participants as $partOne)
        {
            $flag = true;   // индикатор уникальности записи факта участия

            foreach ($partsBD as $suspicious)   // ищем дубликаты среди новых и старых записей из БД
            {
                if ($suspicious->participant_id == $partOne->fio && $suspicious->nomination == $partOne->nomination && $suspicious->teamNameString == $partOne->team && $suspicious->focus == $partOne->focus)
                {
                    $flag = false;
                    break;
                }
            }

            foreach ($arrPart as $suspicious)   // ищем дубликаты в массиве участников из заполненной формы
                if ($suspicious->fio == $partOne->fio && $suspicious->nomination == $partOne->nomination && $suspicious->team == $partOne->team && $suspicious->focus == $partOne->focus)
                {
                    $flag = false;
                    break;
                }

            if ($flag)  // уникальные записи добавим в БД
                $arrPart[] = $partOne;
            else
                Yii::$app->session->addFlash('warning', 'Попытка добавления дубликата акта участия');
        }

        $this->participants = $arrPart;
    }

    private function uploadTeacherParticipants($foreign_event_id)
    {
        if ($this->participants !== null)
        {
            $this->cleanArrParticipant($foreign_event_id);

            foreach ($this->participants as $key => $participantOne)
            {
                $part = new TeacherParticipantWork();
                $part->foreign_event_id = $foreign_event_id;
                $part->participant_id = $participantOne->fio;
                $part->teacher_id = $participantOne->teacher;
                $part->teacher2_id = $participantOne->teacher2;
                $part->focus = $participantOne->focus;
                $part->allow_remote_id = $participantOne->allow_remote_id;
                if ($participantOne->nomination !== 'NULL' && $participantOne->nomination !== '--')
                    $part->nomination = $participantOne->nomination;
                $tpbs = [];
                if ($participantOne->branch !== "")
                    for ($i = 0; $i < count($participantOne->branch); $i++)
                    {
                        $tpb = new TeacherParticipantBranchWork();
                        $tpb->branch_id = $participantOne->branch[$i];
                        $tpbs[] = $tpb;
                    }
                $part->teacherParticipantBranches = $tpbs;
                $part->branchs = $participantOne->branch;
                $part->save();

                if ($participantOne->team !== NULL && $participantOne->team !== '--' && $participantOne->team !== 'NULL')
                {
                    $teamId = TeamNameWork::find()->where(['foreign_event_id' => $foreign_event_id])->andWhere(['name' => $participantOne->team])->one();

                    $team = new TeamWork();
                    $team->teacher_participant_id = $part->id;
                    $team->team_name_id = $teamId->id;
                    $team->save();
                }

                if ($participantOne->fileString != NULL)
                {
                    $partFile = new ParticipantFilesWork();
                    $partFile->teacher_participant_id = $part->id;
                    $partFile->filename = $participantOne->fileString;
                    $partFile->save();
                }
            }
        }
    }
    public function beforeDelete()
    {
        $resp = ResponsibleWork::find()->where(['document_order_id' => $this->id])->all();
        foreach ($resp as $respOne)
            $respOne->delete();

        $orderGroup = OrderGroupWork::find()->where(['document_order_id' => $this->id])->all();
        foreach ($orderGroup as $order)
        {
            /**/ // удаление из связки
            $pasta = OrderGroupParticipantWork::find()->where(['order_group_id' => $order])->all();

            foreach ($pasta as $macaroni)
            {
                $tempId = NULL;

                if ($macaroni->status == 2)
                {
                    $defector = OrderGroupParticipantWork::find()->where(['link_id' => $macaroni->id])->one();
                    $tempId = $defector->group_participant_id;
                    $edit = TrainingGroupParticipantWork::find()->where(['id' => $macaroni->group_participant_id])->one();
                    if ($edit !== NULL)
                    {
                        $edit->status = 0;
                        $edit->save();
                    }
                    if ($defector !== NULL)
                        $defector->delete();
                }

                if ($macaroni->link_id !== NULL)
                {
                    $noDefector = OrderGroupParticipantWork::find()->where(['id' => $macaroni->link_id])->one();
                    $tempId = $macaroni->group_participant_id;
                    $edit = TrainingGroupParticipantWork::find()->where(['id' => $noDefector->group_participant_id])->one();
                    if ($edit !== NULL)
                    {
                        $edit->status = 0;
                        $edit->save();
                    }
                    if ($noDefector !== NULL)
                        $noDefector->delete();
                }

                if ($macaroni->status === 1) // отчисление
                {
                    $edit = TrainingGroupParticipantWork::find()->where(['id' => $macaroni->group_participant_id])->one();
                    if ($edit !== NULL)
                    {
                        $edit->status = 0;
                        $edit->save();
                    }
                }

                if ($macaroni !== NULL)
                {
                    $macaroni->delete();
                    /*if ($tempId !== NULL)
                    {
                        $delGr = TrainingGroupParticipantWork::find()->where(['id' => $tempId])->one();
                        if ($delGr !== NULL)
                            $delGr->delete();
                    }*/
                }
            }
            /**/

            $order->delete();
        }


        if ($this->groups_check !== null && count($this->groups_check) > 0)
        {
            $errorsCheck = new GroupErrorsWork();
            $errorsCheck->CheckOrderTrainingGroup($this->groups_check);
        }

        $errors = OrderErrorsWork::find()->where(['document_order_id' => $this->id])->all();
        foreach ($errors as $error) $error->delete();

        $supplement = DocumentOrderSupplementWork::find()->where(['document_order_id' => $this->id])->one();
        if ($supplement != null) $supplement->delete();

        $foreingEvent = ForeignEventWork::find()->where(['order_participation_id' => $this->id])->one();
        if ($foreingEvent != null) $foreingEvent->delete();

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    private function IsResponsibleDuplicate($people_id)
    {
        if (count(Responsible::find()->where(['document_order_id' => $this->id])->andWhere(['people_id' => $people_id])->all()) > 0)
        {
            $fio = People::find()->where(['id' => $people_id])->one();
            Yii::$app->session->addFlash('error', 'Повторное добавление ответственного: '.
                $fio->secondname.' '.$fio->firstname.' '.$fio->patronymic);
            return true;
        }
        return false;
    }

    public function getDocumentNumber()
    {
        if (strtotime($this->order_date) < strtotime('2021-01-01'))
        {
            $this->order_copy_id = 0;
            Yii::$app->session->addFlash('warning', 'Добавлен архивный приказ. Дата приказа '.$this->order_date);

            return;
        }


        $docs = DocumentOrder::find()->orderBy(['order_date' => SORT_DESC])->all();

        if (date('Y') !== substr($docs[0]->order_date, 0, 4))
            $this->order_copy_id = 1;
        else
        {
            $docs = DocumentOrder::find()->where(['order_number' => $this->order_number])->andWhere(['like', 'order_date', date('Y')])->andWhere(['!=', 'type', '10'])->orderBy(['order_copy_id' => SORT_ASC, 'order_postfix' => SORT_ASC])->all();

            if (end($docs)->order_date > $this->order_date && $this->order_name != 'Резерв')
            {
                $tempId = 0;
                $tempPre = 0;
                if (count($docs) == 0)
                    $tempId = 1;
                for ($i = count($docs) - 1; $i >= 0; $i--)
                {
                    if ($docs[$i]->order_date <= $this->order_date)
                    {
                        $tempId = $docs[$i]->order_copy_id;
                        if ($docs[$i]->order_postfix != null)
                            $tempPre = $docs[$i]->order_postfix + 1;
                        else
                            $tempPre = 1;
                        break;
                    }
                }

                $this->order_copy_id = $tempId;
                $this->order_postfix = $tempPre;
                Yii::$app->session->addFlash('warning', 'Добавленный документ должен был быть зарегистрирован раньше. Номер документа: '.$this->order_number.'/'.$this->order_copy_id.'/'.$this->order_postfix);
            }
            else
            {
                if (count($docs) == 0)
                    $this->order_copy_id = 1;
                else
                {
                    $this->order_copy_id = end($docs)->order_copy_id + 1;
                }
            }
        }

        /*$max = DocumentOut::find()->max('document_number');
        if ($max == null)
            $max = 1;
        else
            $max = $max + 1;
        return $max;*/
    }

    public function getFullName()
    {
        if ($this->order_postfix !== null)
            return $this->order_number.'/'.$this->order_copy_id.'/'.$this->order_postfix.' '.$this->order_name;
        else
            return $this->order_number.'/'.$this->order_copy_id.' '.$this->order_name;
    }

    public function checkForeignKeys()
    {
        $regs1 = Expire::find()->where(['active_regulation_id' => $this->id])->all();
        $regs2 = Expire::find()->where(['expire_regulation_id' => $this->id])->all();
        $regs3 = Regulation::find()->where(['order_id' => $this->id])->all();
        if (count($regs1) > 0 || count($regs2) > 0 || count($regs3) > 0)
            return true;
        else
            return false;
    }

    public function getStateAndColor()
    {
        if ($this->state == 1)
        {
            $change2 = $this->getExpireOrders2();
            if ($change2 !== "")
                return 'Вносит изменения в документы: ' . $change2;

            return 'Актуален';
        }
        else
        {
            $change = $this->getChangeDocs();
            if ($change !== "")
                return 'Был изменен документами: ' . $change;

            $exp = \app\models\work\ExpireWork::find()->where(['expire_order_id' => $this->id])->one();
            $order = \app\models\work\DocumentOrderWork::find()->where(['id' => $exp->active_regulation_id])->one();
            $doc_num = 0;
            if ($order->order_postfix == null)
                $doc_num = $order->order_number.'/'.$order->order_copy_id;
            else
                $doc_num = $order->order_number.'/'.$order->order_copy_id.'/'.$order->order_postfix;
            return 'Утратил силу в связи с приказом '.Html::a('№'.$doc_num, \yii\helpers\Url::to(['document-order/view', 'id' => $order->id]));
        }
    }

    public function getErrorsWork()
    {
        $errorsList = OrderErrorsWork::find()->where(['document_order_id' => $this->id, 'time_the_end' => NULL, 'amnesty' => NULL])->all();
        $result = '';
        foreach ($errorsList as $errors)
        {
            $errorName = ErrorsWork::find()->where(['id' => $errors->errors_id])->one();
            if ($errors->critical == 1)
                $result .= 'Внимание, КРИТИЧЕСКАЯ ошибка: ' . $errorName->number . ' ' . $errorName->name . '<br>';
            else $result .= 'Внимание, ошибка: ' . $errorName->number . ' ' . $errorName->name . '<br>';
        }
        return $result;
    }

    public function getForeignEventLink()
    {
        $foreigns = ForeignEventWork::find()->where(['order_participation_id' => $this->id])->all();
        $result = '';

        foreach ($foreigns as $foreign)
        {
            $result .= Html::a($foreign->name, \yii\helpers\Url::to(['foreign-event/view', 'id' => $foreign->id]));
            if ($foreign->getErrorsWork() !== '')
                $result .= '<span style="color:red"> (содержит ошибки)</span>';
            $result .= '<br>';
        }

        return $result;
    }
}