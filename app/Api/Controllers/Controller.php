<?php

namespace App\Api\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use Helpers;
}
