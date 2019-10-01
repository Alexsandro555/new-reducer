<?php
namespace Modules\Product\Exceptions;

use Throwable;

class FormatAttributeValueException extends myNotFoundException
{
  public function __construct(string $message = "")
  {
    parent::__construct($message);
  }
}