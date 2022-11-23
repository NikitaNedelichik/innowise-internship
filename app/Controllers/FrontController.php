<?php

namespace Innowise\app\Controllers;

use Innowise\app\Helpers\FileHelper;
use Innowise\system\Request;

class FrontController extends MainController
{
    private FileHelper $helper;

    public function __construct()
    {
        parent::__construct();
        $this->helper = new FileHelper();
    }

    public function index(): string
    {
        return $this->view->render('index', [
            'session' => $_SESSION
        ]);
    }

    public function upload(): string
    {
        $data = $this->helper->uploadFile(Request::getUploadedFileData());

        return $this->view->render('upload', [
            'session' => $_SESSION,
            'file' => $data['file'],
            'files' => $data['files'],
            'message' => $data['message']
        ]);
    }
}
