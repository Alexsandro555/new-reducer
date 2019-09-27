<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class AttributeRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    if(Request::isMethod('patch')) {
      return [
        'title' => 'required'
      ];
    } else {
      return [

      ];
    }
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [
      'title.unique' => "Атрибут с заданным именем уже существует"
    ];
  }
}
