<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Initializer\Traits\ControllerTrait;
use Modules\Page\Entities\Page;

class PageController extends Controller
{
  use ControllerTrait;

  public $model;

  public function __construct()
  {
    $this->model = new Page;
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show($slug)
  {
    $article = Page::where('url_key', $slug)->firstOrFail();
    return view('article::show', compact('article'));
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('page::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
  }

  /**
   * @param Request $request
   * @return array
   */
  public function destroy(Request $request)
  {
    $page = Page::findOrFail($request->id);
    $currentFiles = File::where('fileable_id', $request->id)->where('fileable_type', Page::class)->get();
    foreach ($currentFiles as $currentFile) {
      $currentFile->delete();
    }
    $id = $page->id;
    $page->delete();
    return ['message' => 'Успешно удалено!', 'id' => $id];
  }
}
