<?php

namespace app\services;
use app\commands\Generator_helpers;
use app\repositories\TransferFileRepository;

class TransferFileService
{
    public TransferFileRepository $transferFileRepository;
    public function __construct(TransferFileRepository $transferFileRepository)
    {
        $this->transferFileRepository = $transferFileRepository;
    }
    public function insertDoc($currentDirectory, $doc_in, $table){
        $filepath = $currentDirectory."/doc/";
        $filename = $doc_in->doc;
        $fileArray = (new Generator_helpers\DocHelper)->splitFile($filename);
        foreach ($fileArray as $file) {
            $results = $this->transferFileRepository->findByPath($filepath, $file);
            if($results == 0) {
                $type = 'doc';
                $this->transferFileRepository->insertDoc($table, $doc_in, $type, $filepath, $file );
            }
        }
    }
    public function insertScan($currentDirectory, $doc_in, $table){
        $filepath = $currentDirectory."/scan/";
        $filename = $doc_in->scan;
        $fileArray = (new Generator_helpers\DocHelper)->splitFile($filename);
        foreach ($fileArray as $file) {
            $results = $this->transferFileRepository->findByPath($filepath, $file);
            if($results == 0) {
                $type = 'scan';
                $this->transferFileRepository->insertDoc($table, $doc_in, $type, $filepath, $file);
            }
        }
    }
    public function insertScanTwo($currentDirectory, $doc_in, $table){
        $filepath = $currentDirectory."/scan/";
        $filename = $doc_in->Scan;
        $fileArray = (new Generator_helpers\DocHelper)->splitFile($filename);
        foreach ($fileArray as $file) {
            $results = $this->transferFileRepository->findByPath($filepath, $file);
            if($results == 0) {
                $type = 'scan';
                $this->transferFileRepository->insertDoc($table, $doc_in, $type, $filepath, $file);
            }
        }
    }
    public function insertApplication($currentDirectory, $doc_in, $table){
        $filepath = $currentDirectory."/applications/";
        $filename = $doc_in->applications;
        $fileArray = (new Generator_helpers\DocHelper)->splitFile($filename);
        foreach ($fileArray as $file) {
            $results = $this->transferFileRepository->findByPath($filepath, $file);
            if($results == 0) {
                $type = 'application';
                $this->transferFileRepository->insertDoc($table, $doc_in, $type, $filepath, $file );
            }
        }
    }
}