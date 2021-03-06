<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
	protected $uploadService;

	function __construct()
	{
		$this->uploadService = app()->make('UploadService');
	}

    public function uploadProductImage(Request $request)
    {
    	$file = $request->file('file');
    	$id = $request->input('id');
    	return $this->uploadService->uploadProductImage($file, $id, 'images/products/');
    }

    public function delImageProduct($id)
    {
    	return $this->uploadService->delProductImage($id);
    }
}
