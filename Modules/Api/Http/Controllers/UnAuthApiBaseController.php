<?php
/**
 * Created by PhpStorm.
 * User: pirago
 * Date: 2019-03-03
 * Time: 16:20
 */

namespace Modules\Api\Http\Controllers;


use App\Http\Controllers\PaperlessUnAuthBaseController;

class UnAuthApiBaseController extends PaperlessUnAuthBaseController
{
    use ApiResponseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->middleware([
            'language'
        ]);
    }

    function hello(){
        return $this->returnSuccess('Hello!');
    }

}