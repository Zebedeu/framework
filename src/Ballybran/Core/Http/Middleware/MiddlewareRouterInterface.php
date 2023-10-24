<?php

namespace Ballybran\Core\Http\Middleware;

use Ballybran\Core\Http\Request;
use Ballybran\Core\Http\Response;

interface MiddlewareRouterInterface {

    
    function handle(Request $request, Response $response);

}