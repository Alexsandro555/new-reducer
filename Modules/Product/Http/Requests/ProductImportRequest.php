<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'file' => 'required|file|max:' . config('info.maxsize_file') . '|mimes:xls',
      'product_category_id' => 'required'
    ];
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
      'file.required' => "Не выбран файл",
      'file.mimes' => 'Поддерживаются только файлы формата excel (.xls)',
      'file.max' => "Максимальный размер загружаемого файла не должен превышать ".(config('info.maxsize_file')/1024)."МБ (".config('info.maxsize_file')."КB).  В случае невозможности уменьшить размер файла обратитесь к системному админстратору ".config('info.admin_email'),
      'product_category_id.required' => "Необходимо выбрать категорию для продукции"
    ];
  }
}
