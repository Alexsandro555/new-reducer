<?php
namespace Modules\Files\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
  const PATH = "app/public/";

  private $files;

  protected $fillable = [
      'fileable_id', 'fileable_type', 'type_file_id', 'config', 'original_name'
  ];

  /**
   * Get all the owning fileable models
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function fileable() {
      return $this->morphTo();
  }

  public function typeFile() {
    return $this->belongsTo('Modules\Files\Entities\TypeFile');
  }

  public function figure()
  {
    return $this->hasMany(Figure::class);
  }

  protected $casts = [
    'config' => 'collection',
  ];

  protected function sanitize($string, $force_lowercase = true, $anal = false)
  {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
      "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
      "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

    return ($force_lowercase) ?
      (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
      $clean;
  }

  private function createUniqueFilename()
  {
    // Generate token for image
    $imageToken = substr(sha1(mt_rand()), 0, 5);
    $originalNameWithoutExt = substr(request('file')->getClientOriginalName(), 0, strlen(request('file')->getClientOriginalName()) - strlen(request('file')->getClientOriginalExtension()) - 1);
    return  $this->sanitize($originalNameWithoutExt). '-' . $imageToken . '.' . request('file')->getClientOriginalExtension();
  }

  public function saveToFolder($file)
  {
    $allowed_filename = $this->createUniqueFilename();
    Storage::put('public/'. $allowed_filename,$file);
    return $allowed_filename;
  }

  public function storeResizeImage($arrInfoImage)
  {
    $allowedFilename = $this->createUniqueFilename();
    Storage::put('public/'.$allowedFilename,$arrInfoImage['image']);

    $file = collect();
    $file->put("filename",$allowedFilename);
    $file->put("size",$arrInfoImage["size"]);
    $file->put("width",$arrInfoImage["width"]);
    $file->put("height",$arrInfoImage["height"]);
    $file->put("resize",$arrInfoImage["resize"]);

    $this->files[$arrInfoImage["resize"]["name"]] = $file;

    if($arrInfoImage["resize"]["name"] == "original") {
      $this->original_name = $allowedFilename;
    }

    $config = collect();
    $config->put('files',$this->files);
    $this->config = $config;
  }

  protected static function boot()
  {
      parent::boot(); // TODO: Change the autogenerated stub

      static::deleting(function($file) {
          $full_size_dir = storage_path('app/public/');
          foreach ($file->config as $itemFiles) {
            foreach ($itemFiles as $itemFile) {
              $fileDir = $full_size_dir.$itemFile["filename"];
              unlink($fileDir);
            }
          }
      });
  }
}