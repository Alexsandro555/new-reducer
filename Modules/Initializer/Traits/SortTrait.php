<?php

namespace Modules\Initializer\Traits;

trait SortTrait {
  protected static function bootSortTrait() {
    static::creating(function($model) {
      $model->sort = $model::orderBy('created_at','desc')->first()->sort+1;
    });
  }
}