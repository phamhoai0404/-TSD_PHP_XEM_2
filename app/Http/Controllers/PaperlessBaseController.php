<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PaperlessBaseController extends Controller
{
    protected $user = null;
    protected $guard = 'web';

    public function __construct(){

        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard($this->guard)->user();

            return $next($request);
        });
    }
}
