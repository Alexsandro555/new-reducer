<?php

namespace Modules\Files\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Files\Http\Requests\FileRequest;
use Modules\Files\Services\ImageManipulationService;
use Modules\Files\Entities\File;

class WysiwygController extends Controller
{
  public function store(FileRequest $request, ImageManipulationService $service)
  {
    $file = new File;
    if($request->resize) {
      foreach($request->resize as $size) {
        $arrInfoImage = $service->resize($size);
        $arrInfoImage['resize'] = $size;
        $file->storeResizeImage($arrInfoImage);
      }
    } else {
      $file->config = collect();
    }

    $file->original_name = $file->saveToFolder($request->file());
    $file->type_file_id = $request->typeFile->id;
    $file->fileable_id = $request->fileable_id;
    $file->fileable_type = $request->fileable_type;
    $file->save();
    return $file;
  }
}