<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\PaperlessBaseController;

class AuthApiBaseController extends PaperlessBaseController
{
    use ApiResponseTrait;

    protected $guard = 'api';

    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth:api',
            'language'
        ]);
    }
}
