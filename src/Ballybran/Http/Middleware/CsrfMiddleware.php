<?php

namespace Ballybran\Http\Middleware;

use Ballybran\Exception\BadRequestHttpException;
use Ballybran\Http\Middleware;
use Ballybran\Http\Request;

class CsrfMiddleware extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * This method will be triggered
     * when the middleware is called
     *
     * @param Request $request
     *
     * @return bool
     */
    public function handle(Request $request)
    {
        $uri = trim(str_replace(app()->baseFolder(), '', $request->getRequestUri()), '/');
        if (!in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']) && !$this->skip($uri)) {
            $token = $request->input('_token') ?: $request->header('X-CSRF-Token');
            $tokenForm = $request->input('_token_form');
            if (empty($token) || !csrf_check($token, $tokenForm)) {
                return $this->failed($request);
            }
        }

        return true;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function failed(Request $request)
    {
        throw new BadRequestHttpException;
    }

    /**
     * @param string $uri
     *
     * @return bool
     */
    protected function skip(string $uri): bool
    {
        foreach ($this->except as $value) {
            $pattern = '#^(' . str_replace('/', '\/', $value) . ')#si';
            if (preg_match($pattern, $uri)) {
                return true;
            }
        }

        return false;
    }
}
