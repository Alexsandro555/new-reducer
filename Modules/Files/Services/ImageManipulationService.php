<?php

namespace Modules\Files\Services;

use Intervention\Image\ImageManager;

class ImageManipulationService
{
  private $originalImage;
  private $imageManager;

  public function __construct()
  {
    $this->originalImage = request('file');
    $this->imageManager = new ImageManager();
  }

  protected function resizeAbsolute($width, $height)
  {
    return $this->imageManager->make($this->originalImage)->resize($width,$height);
  }

  protected function resizeRelative($width, $height)
  {
    return $this->imageManager->make($this->originalImage)->resize($width, $height, function($constraing) {
      $constraing->aspectRatio();
      $constraing->upsize();
    });
  }


  public function resize($size)
  {
    if($size['absolute']) {
      $image = $this->resizeAbsolute($size["width"], $size["height"]);
    } else {
      $image = $this->resizeRelative($size["width"], $size["height"]);
    }
    return ['image' => $image->encode($this->originalImage->getClientOriginalExtension()), 'size' => $image->filesize(), 'width' => $image->width(), 'height' => $image->height()];
  }

}
