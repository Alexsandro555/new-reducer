<?php

namespace Modules\Files\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Files\Classes\UploadInfo;
use Modules\Files\Entities\Figure;
use Modules\Files\Services\UploadService;
use Modules\Files\Entities\File;
use Modules\Product\Entities\LineProduct;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\TypeProduct;
use SebastianBergmann\Diff\Line;

class FilesController extends Controller
{
  /**
   * Upload file
   *
   * @param UploadService $uploadService
   * @param UploadInfo $uploadInfo
   * @return array
   * @throws \Exception
   */
  public function store(UploadService $uploadService, UploadInfo $uploadInfo) {
    if ($uploadService->upload()) {
      return ['id' => $uploadInfo->currentFileId, 'message' => 'Успешно загружено!'];
    } else {
      throw new \Exception('Загрузка не удалась - не должно возникать');
    }
  }


  /**
   * @param UploadService $uploadService
   * @param UploadInfo $uploadInfo
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function storeWysiwyg(UploadService $uploadService, UploadInfo $uploadInfo) {
    if ($uploadService->upload()) {
      $file = File::find($uploadInfo->currentFileId);
      $arrFiles = [];
      foreach ($file->config as $files) {
        foreach ($files as $key => $file) {
          if ($key !== 'original') {
            $fileItem['filename'] = $file["filename"];
            $fileItem['width'] = $file["width"];
            $fileItem['height'] = $file["height"];
            $arrFiles[] = $fileItem;
          }
        }
      }
      return response()->json(['error' => false, 'files' => $arrFiles], 200);
    } else {
      throw new \Exception('Загрузка не удалась - не должно возникать');
    }
  }

  /**
   *  Get Files
   * @param int $id
   * @return \Illuminate\Http\Response:json
   */
  public function getImages(Request $request)
  {
    $files = File::where('fileable_id',$request->id)->where('fileable_type',$request->model)->get();
    return response()->json($files,200);
  }

  /**
   *  Delete Image
   * @param int $id
   * @return \Illuminate\Http\Response:json
   */
  public function deleteFile($id)
  {
    $file = File::find($id);
    if($file) {
      $file->delete();
      return response()->json(['message' => 'Успешно удалено'],200);
    }
    else {
      return response()->json(['message' => 'Не существующий идентефикатор'],422);
    }
  }

  public function productImage($id) {
    // TODO: требуется выполнить оптимизацию #1 проблема
    $product = Product::findOrFail($id);
    return File::with('typeFile')->where(function ($query) use (&$product) {
      $query->where('fileable_id', $product->product_category_id)->where('fileable_type', ProductCategory::class);
    })->orWhere(function ($query) use (&$product) {
      $query->where('fileable_id', $product->type_product_id)->where('fileable_type', TypeProduct::class);
    })->orWhere(function ($query) use (&$product) {
      $query->where('fileable_id', $product->line_product_id)->where('fileable_type', LineProduct::class);
    })->orWhere(function ($query) use (&$product) {
      $query->where('fileable_id', $product->id)->where('fileable_type', Product::class);
    })->get();
  }


  public function figure($id) {
    $image = File::findOrFail($id);
    $imagePath = storage_path('app/public/'.$image->config['files']['medium']['filename']);
    $extension = pathinfo($imagePath)['extension'];
    $size = filesize($imagePath);
    switch ($extension)
    {
      case "jpg":
        header("Content-Type: image/jpeg");
        $img = imagecreatefromjpeg($imagePath);
        break;
      case "gif":
        header("Content-Type: image/gif");
        $img = imagecreatefromgif($imagePath);
        break;
      case "png":
        header("Content-Type: image/png");
        $img = imagecreatefrompng($imagePath);
        break;
      default:
        break;
    }
    if($img) {
      $orig_width = imagesx($img);
      $orig_height = imagesy($img);

      // какие-то установки цвета - для чего они вообще нужны?
      $index = imagecolorresolve ( $img, 227,227,227 );
      imagecolorset($img, $index, 255, 255, 255);
      $index = imagecolorresolve ( $img, 229,229,229 );
      imagecolorset($img, $index, 255, 255, 255);
      $color = imagecolorallocatealpha($img, 0, 0, 0, 0);
      $color0=imagecolorallocatealpha($img, 255, 0, 0, 0);
      $color1=imagecolorallocatealpha($img, 0, 0, 255, 0);

      $arrayF=$image->figure->toArray();
      foreach ($arrayF as $key=>$value) {
        if (preg_match("#din#i",$key)) {
          if (trim($image->figure->{$key})!='') {
            $arrF=explode("|",$image->figure->{$key});
            for ($i=0;$i<count($arrF);$i++) {
              list($x,$y,$angle)=explode("/",$arrF[$i]);
              $x=round(imagesx($img)/100*$x);
              $y=round(imagesy($img)/100*$y);
              //$product->{$key}=str_replace("&diam;","&#216;",$product->{$key});
              putenv('GDFONTPATH=' . $_SERVER["DOCUMENT_ROOT"].'/fonts/msttcorefonts/');
              $box = imagettftext($img, 10, $angle,$x, $y,$color, "arial.ttf", '777');
              header('Content-Length: ' . $size);
              switch ($extension)
              {
                case "jpg":
                  return imagejpeg($img);
                case "gif":
                  return imagegif($img);
                case "png":
                  return imagepng($img);
                default:
                  break;
              }
            }
          }
        }
      }
    }
    return $img;
  }

}
