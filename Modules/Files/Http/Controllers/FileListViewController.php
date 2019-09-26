<?php

namespace Modules\Files\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Files\Entities\FileListView;

class FileListViewController extends Controller
{
  Use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new FileListView;
  }
}
