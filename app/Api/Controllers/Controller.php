<?php

namespace App\Api\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Dingo\Api\Routing\Helpers;

abstract class Controller extends BaseController
{
    use Helpers;
}
