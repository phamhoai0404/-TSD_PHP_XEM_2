<?php

namespace Modules\Web\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\Web\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App;

class LocaleController extends Controller
{
    public function index($lang) {
        App::setLocale($lang);
        return view('web::top');
    }
}