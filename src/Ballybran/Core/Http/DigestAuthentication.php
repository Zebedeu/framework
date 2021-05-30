<?php

namespace Ballybran\Core\Http;



class DigestAuthentication
{
    private $username;
    private $password;
    private $realm = 'Restricted area';

    /**
     * @return string
     */
    public function getRealm(): string
    {
        return $this->realm;
    }

    /**
     * @param string $realm
     */
    public function setRealm(string $realm): void
    {
        $this->realm = $realm;
    }

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function __invoke()
    {


//user => password
        $users = array('zebedeu' => '1234' , 'guest' => 'guest');


        if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Digest realm="' . $this->getRealm() .
                '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($this->getRealm()) . '"');

            die('Text to send if user hits Cancel button');
        }



    $data = $this->checkUserPassword($users);
// generate the valid response
        $A1 = md5($data['username'] . ':' . $this->getRealm() . ':' . $users[$data['username']] . ':' . $users[$data['password']]);
        $A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $data['uri']);
        $valid_response = md5($A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $A2);

        if ($data['response'] != $valid_response) {
            die('Wrong Credentials!');

        }
        echo 'You are logged in as: ' . $data['username'];


    }

// function to parse the http auth header
    function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce' => 1 , 'nc' => 1 , 'cnonce' => 1 , 'qop' => 1 , 'username' => 1 , 'uri' => 1 , 'response' => 1);
        $data = array();
        $keys = implode('|' , array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@' , $txt , $matches , PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return !empty($needed_parts) ? false : $data;
    }

    /*
     * analyze the PHP_AUTH_DIGEST variable
     *
     */

    public function checkUserPassword($users){
        $data = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);
        var_dump($data);
        if (!($data) || ! isset($users[$data['username']])) {
            die('Wrong Credentials!');
        }
        return $data;

    }

}