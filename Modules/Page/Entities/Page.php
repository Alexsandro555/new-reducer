<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Files\Entities\File;
use Modules\Initializer\Traits\RelationTrait;
use Modules\Initializer\Traits\TableColumnsTrait;
use Modules\Initializer\Traits\DefaultTrait;

class Page extends Model
{
  use SoftDeletes, RelationTrait, TableColumnsTrait, DefaultTrait;

  protected $dates = ['deleted_at','updated_at'];

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'title' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255
      ]
    ],
    'url_key' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255,
        'regex' => '^[a-z0-9-]+$',
      ]
    ],
    'content' => [
      'enabled' => true
    ]
  ];

  protected $guarded = [];

  public function setTitleAttribute($value) {
    $this->attributes['title'] = strip_tags($value);
  }

  public function files() {
    return $this->morphMany(File::class, 'fileable');
  }
}
