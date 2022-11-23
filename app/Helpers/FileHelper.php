<?php

namespace Innowise\app\Helpers;

use Innowise\app\Models\FileModel;
use Innowise\app\Services\Logger;
use Innowise\app\Services\Validate;
use Innowise\system\Request;

class FileHelper
{
    private Logger $log;
    private string $message;
    private FileModel $model;
    private array $files = [];
    const UPLOAD_DIR = "/uploads/";
    private Validate $validator;

    public function __construct()
    {
        $this->validator = new Validate();
        $this->log = new Logger();
    }

    public function uploadFile($data): array
    {
        if (Request::isPost()) {
            $canLoad = $this->loadData($data['file']);
            if ($canLoad !== true) {
                $this->message = $canLoad;
            } else {
                $name = $data['file']['name'];
                $type = $data['file']['type'];
                $size = $data['file']['size'];
                $tmpName = $data['file']['tmp_name'];
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/../' . self::UPLOAD_DIR;
                @mkdir($uploadDir, 0777);
                move_uploaded_file($tmpName, $uploadDir . $this->setRandomName($type));
                $this->model = new FileModel($name, $size, $type);
                $this->message = 'The file is uploaded';
                $this->log->createLog($this->message);
            }
        }

        return [
            'message' => $this->message ?? '',
            'files' => $this->getFiles(),
            'file' => $this->model ?? ''
        ];
    }

    private function setRandomName($type): string
    {
        $addingType = explode('/', $type);
        $date = date('dmY_His');
        return uniqid($date . '_') . '.' . $addingType[1];
    }

    private function getFiles(): array
    {
        $uploadDir = '..' . self::UPLOAD_DIR;
        $handle = opendir($uploadDir);
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $this->files[] = $file;
            }
        }

        return $this->files;
    }

    private function loadData($data)
    {
        if (empty($data['name'])) {
            $this->message = 'Upload the file, please (file is not uploaded)';
            $this->log->createLog($this->message);
            return $this->message;
        }

        if ($data['error'] > 0) {
            $this->message = 'File is not uploaded. We have an error. Try Again.';
            $this->log->createLog($this->message);
            return $this->message;
        }

        return $this->isValid($data);
    }

    private function isValid($data)
    {
        return $this->validate($data);
    }

    private function validate($data)
    {
        if ($this->validator->isValidSize($data['size']) !== true) {
            $this->message = $this->validator->getError('size');
            $this->log->createLog($this->message);
            return $this->message;
        }

        if ($this->validator->isValidType($data['type']) !== true) {
            $this->message = $this->validator->getError('type');
            $this->log->createLog($this->message);
            return $this->message;
        }

        return true;
    }
}
