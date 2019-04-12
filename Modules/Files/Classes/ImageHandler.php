<?php

namespace Modules\Files\Classes;

use Illuminate\Support\Facades\Storage;

class ImageHandler extends AbstractImageManipulation
{
  public function __construct()
  {
    parent::__construct();
  }

  public function handling($file, $config)
  {
    $image = $this->manager->make($file);
    // Получаем оригинальное название файла
    $original = $image->getClientOriginalName();
    // сохраняем оригинальны файл
    $fileName = $this->getAllowedFilename($original);
    Storage::put('/public', $file, $fileName);

    $fileCollect = collect();

    $collection = collect();
    $collection->put('filename', $fileName);
    $collection->put('size', $file->getClientSize());
    $collection->put('width', $file->width());
    $collection->put('height', $file->height());

    // если необходим resize выполняем его
    if (isset($config['resize'])) {
      foreach ($config['resize'] as $type) {
        $image = isset($type["absolute"]) && $type["absolute"] ? $this->resizeAbsolute($file, $type["width"], $type["height"]) : $this->resizeRelative($file, $type["width"], $type["height"]);
        $fileName = $this->getAllowedFilename($original);
        Storage::put('/public', $image, $fileName);
        $collection = collect();
        $collection->put('size', $image->size($image));
        $collection->put('width', $type["width"]);
        $collection->put('height', $type["height"]);
        $resize = $config->get('resize');
        $fileCollect->put('files', $collection);

      }
    }
    return $fileCollect;
  }
}