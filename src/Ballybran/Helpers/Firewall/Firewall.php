<?php


namespace Ballybran\Helpers\Firewall;


class Firewall
{

    private static $_IP_TYPE_SINGLE = 'single';
    private static $_IP_TYPE_WILDCARD = 'wildcard';
    private static $_IP_TYPE_MASK = 'mask';
    private static $_IP_TYPE_SECTION = 'section';
    private $lacklists;
    private $_allowed_ips = array();
    private $add = [];

    /**
     * @return mixed
     */
    public function getAdd()
    {
        return $this->add;
    }


    public function __construct($allowed_ips)
    {
        $this->_allowed_ips = $allowed_ips;
    }


    public function addList($ip)
    {

        $this->add = $ip;
        return $this;

    }

    public function blackList($lacklists = null)
    {
        if ($lacklists) {

            if (is_array($lacklists)) {

                foreach ($lacklists as $key => $lacklist) {
                    return $this->_allowed_ips = $lacklist;
                }
            }
            return $this->lac_allowed_ipsklist = $lacklists;

        }
    }

    public function check($allowed_ips = null)
    {
        $allowed_ips = $allowed_ips ?? $this->_allowed_ips;

        foreach ($allowed_ips as $allowed_ip) {
            $type = $this->_judge_ip_type($allowed_ip);
            $sub_rst = call_user_func(array($this, '_sub_checker_' . $type), $allowed_ip, $this->getAdd());

            if ($sub_rst) {
                return true;
            }

        }

        return false;
    }

    private function _judge_ip_type($ip)
    {
        if (strpos($ip, '*')) {
            return self:: $_IP_TYPE_WILDCARD;
        }

        if (strpos($ip, '/')) {
            return self:: $_IP_TYPE_MASK;
        }

        if (strpos($ip, '-')) {
            return self:: $_IP_TYPE_SECTION;
        }

        if (ip2long($ip)) {
            return self:: $_IP_TYPE_SINGLE;
        }

        return false;
    }

    private function _sub_checker_single($allowed_ip, $ip)
    {
        return (ip2long($allowed_ip) == ip2long($ip));
    }

    private function _sub_checker_wildcard($allowed_ip, $ip)
    {
        $allowed_ip_arr = explode('.', $allowed_ip);
        $ip_arr = explode('.', $ip);
        for ($i = 0; $i < count($allowed_ip_arr); $i++) {
            if ($allowed_ip_arr[$i] == '*') {
                return true;
            } else {
                if (false == ($allowed_ip_arr[$i] == $ip_arr[$i])) {
                    return false;
                }
            }
        }
    }

    private function _sub_checker_mask($allowed_ip, $ip)
    {
        list($allowed_ip_ip, $allowed_ip_mask) = explode('/', $allowed_ip);
        $begin = (ip2long($allowed_ip_ip) & ip2long($allowed_ip_mask)) + 1;
        $end = (ip2long($allowed_ip_ip) | (~ip2long($allowed_ip_mask))) + 1;
        $ip = ip2long($ip);
        return ($ip >= $begin && $ip <= $end);
    }

    private function _sub_checker_section($allowed_ip, $ip)
    {
        list($begin, $end) = explode('-', $allowed_ip);
        $begin = ip2long($begin);
        $end = ip2long($end);
        $ip = ip2long($ip);
        return ($ip >= $begin && $ip <= $end);
    }

    public function find_net($host, $mask)
    {
        $broadcast = "";
        ### Function to determine network characteristics
        ### $host = IP address or hostname of target host (string)
        ### $mask = Subnet mask of host in dotted decimal (string)
        ### returns array with
        ###   "cidr"      => host and mask in CIDR notation
        ###   "network"   => network address
        ###   "broadcast" => broadcast address
        ###
        ### Example: find_net("192.168.37.215","255.255.255.224")
        ### returns:
        ###    "cidr"      => 192.168.37.215/27
        ###    "network"   => 192.168.37.192
        ###    "broadcast" => 192.168.37.223
        ###

        $bits = strpos(decbin(ip2long($mask)), "0");
        $net["cidr"] = gethostbyname($host) . "/" . $bits;

        $net["network"] = long2ip(bindec(decbin(ip2long(gethostbyname($host))) & decbin(ip2long($mask))));

        $binhost = str_pad(decbin(ip2long(gethostbyname($host))), 32, "0", STR_PAD_LEFT);
        $binmask = str_pad(decbin(ip2long($mask)), 32, "0", STR_PAD_LEFT);
        for ($i = 0; $i < 32; $i++) {
            if (substr($binhost, $i, 1) == "1" || substr($binmask, $i, 1) == "0") {
                $broadcast .= "1";
            } else {
                $broadcast .= "0";
            }
        }
        $net["broadcast"] = long2ip(bindec($broadcast));

        return $net;
    }

    public function ipToHex($ipAddress)
    {
        $hex = '';
        if (strpos($ipAddress, ',') !== false) {
            $splitIp = explode(',', $ipAddress);
            $ipAddress = trim($splitIp[0]);
        }
        $isIpV6 = false;
        $isIpV4 = false;
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $isIpV6 = true;
        } else if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $isIpV4 = true;
        }
        if (!$isIpV4 && !$isIpV6) {
            return false;
        }
        // IPv4 format
        if ($isIpV4) {
            $parts = explode('.', $ipAddress);
            for ($i = 0; $i < 4; $i++) {
                $parts[$i] = str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
            }
            $ipAddress = '::' . $parts[0] . $parts[1] . ':' . $parts[2] . $parts[3];
            $hex = join('', $parts);
        } // IPv6 format
        else {
            $parts = explode(':', $ipAddress);
            // If this is mixed IPv6/IPv4, convert end to IPv6 value
            if (filter_var($parts[count($parts) - 1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
                $partsV4 = explode('.', $parts[count($parts) - 1]);
                for ($i = 0; $i < 4; $i++) {
                    $partsV4[$i] = str_pad(dechex($partsV4[$i]), 2, '0', STR_PAD_LEFT);
                }
                $parts[count($parts) - 1] = $partsV4[0] . $partsV4[1];
                $parts[] = $partsV4[2] . $partsV4[3];
            }
            $numMissing = 8 - count($parts);
            $expandedParts = array();
            $expansionDone = false;
            foreach ($parts as $part) {
                if (!$expansionDone && $part == '') {
                    for ($i = 0; $i <= $numMissing; $i++) {
                        $expandedParts[] = '0000';
                    }
                    $expansionDone = true;
                } else {
                    $expandedParts[] = $part;
                }
            }
            foreach ($expandedParts as &$part) {
                $part = str_pad($part, 4, '0', STR_PAD_LEFT);
            }
            $ipAddress = join(':', $expandedParts);
            $hex = join('', $expandedParts);
        }
        // Validate the final IP
        if (!filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            return false;
        }
        return strtolower(str_pad($hex, 32, '0', STR_PAD_LEFT));
    }

    public function CalculateIPRange($iprange)
    {
        // Daevid Vincent [daevid@daevid.com] 10.13.03
        //  This function will return an array of either a negative error code
        //  or all possible IP addresses in the given range.
        //  format is NNN.NNN.NNN.NNN - NNN.NNN.NNN.NNN  (spaces are okay)

        $temp = preg_split("/-/", $iprange, -1, PREG_SPLIT_NO_EMPTY);
        $QRange1 = $temp[0];
        $QRange2 = $temp[1];

        if ($QRange2 == "") return array($QRange1); //special case, they didn't put a second quad parameter

        //basic error handling to see if it is generally a valid IP in the form N.N.N.N
        if (preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $QRange1) != 1) return array(-1);
        if (preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $QRange2) != 1) return array(-1);

        $quad1 = explode(".", $QRange1);
        $quad2 = explode(".", $QRange2);

        reset($quad1);
        while (list ($key, $val) = each($quad1)) {
            $quad1[$key] = intval($val);
            if ($quad1[$key] < 0 || $quad1[$key] > 255) return array(-2);
        }
        reset($quad2);
        while (list ($key, $val) = each($quad2)) {
            $quad2[$key] = intval($val);
            if ($quad2[$key] < 0 || $quad2[$key] > 255) return array(-2);
        }

        $startIP_long = sprintf("%u", ip2long($QRange1));
        $endIP_long = sprintf("%u", ip2long($QRange2));
        $difference = $endIP_long - $startIP_long;
        //echo "startIP_long = ".$startIP_long." and endIP_long = ".$endIP_long." difference = ".$difference."<BR>";

        $ip = array();
        $k = 0;
        for ($i = $startIP_long; $i <= $endIP_long; $i++) {
            $temp = long2ip($i);

            //this is a total hack. there must be a better way.
            $thisQuad = explode(".", $temp);
            if ($thisQuad[3] > 0 && $thisQuad[3] < 255)
                $ip[$k++] = $temp;
        }

        return $ip;
    } //CalculateIPRange()

}
