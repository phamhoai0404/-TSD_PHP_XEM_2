<?php
/**
 * Created by PhpStorm.
 * User: pirago
 * Date: 2019-03-03
 * Time: 17:29
 */

namespace Modules\Web\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class RootController extends WebBaseController
{

    function index()
    {
        return view('web::top');
    }

}