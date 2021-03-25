<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    protected $firebaseService;

    public function __construct() {
        $this->firebaseService = app()->make('FirebaseService');
    }

    public function getMessages(Request $request)
    {
        return $this->firebaseService->getMessages();
    }

    public function setMessages(Type $var = null)
    {
        # code...
    }
}
