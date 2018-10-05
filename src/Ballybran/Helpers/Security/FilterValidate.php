<?php
/**
 * Created by PhpStorm.
 * User: marciozebedeu
 * Date: 14/09/18
 * Time: 22:57
 */

namespace Ballybran\Helpers\Security;


class FilterValidate
{

    private $domain;
    private $url;
    private $ip;


    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        if(!filter_var($domain, FILTER_VALIDATE_DOMAIN)){
            throw new \InvalidArgumentException("the value entered must have a Domain");
        }
        $this->domain = $domain;

    }

    public function setUrl($url)
    {
        if(!filter_var($this->url, FILTER_VALIDATE_URL)){
            throw new \InvalidArgumentException("the value entered must have a Url");
        }
        $this->url = $url;

    }


    public function setIp($ip)
    {
        if(!filter_var($ip, FILTER_VALIDATE_IP)){
            throw new \InvalidArgumentException("the value entered must have a Ip");
        }
        $this->ip = $ip;
    }


}