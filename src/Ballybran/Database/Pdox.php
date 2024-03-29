<?php

namespace Ballybran\Database;

use Ballybran\Route\Pdox as PdoxProvider;

class Pdox extends PdoxProvider
{
    /**
     * Class constructor
     *
     * @return PdoxProvider
     */
    public function __construct()
    {
        $config = config('database');
        $activeDb = $config['connections'][$config['default']];
        if ($activeDb['driver'] === 'sqlite') {
            $activeDb['database'] = database_path($activeDb['database']);
        }
        $activeDb['cachedir'] = cache_path('sql');
        $activeDb['debug'] = app()->isLocal();
        return parent::__construct($activeDb);
    }

    /**
     * Call function for Class
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }
}