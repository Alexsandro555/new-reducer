<?php

namespace Modules\Callback\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationTrait;
use App\Traits\TableColumnsTrait;

class Callback extends Model
{
  use SoftDeletes;
  use RelationTrait;
  use TableColumnsTrait;

  protected $dates = ['deleted_at'];

  protected $guarded = [];

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'name' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255
      ]
    ],
    'company_name' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 50
      ]
    ],
    'telephone' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 50
      ]
    ],
    'email' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 50
      ]
    ]
  ];
}
