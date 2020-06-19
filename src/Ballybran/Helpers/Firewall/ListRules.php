<?php
/**
 * Created by PhpStorm.
 * User: marciozebedeu
 * Date: 15/09/18
 * Time: 10:57
 */

namespace Ballybran\Helpers\Firewall;

class ListRules
{

    public function rules($rules)
    {
        $_POST['nome'] = "bgsound";
        foreach ($_POST as $value) {
            $check = str_replace($rules, '*', $value);
            if ($value != $check) {
                die('Cookie protect');
                unset($value);
            }
        }

    }


    public function addList($list, $value)
    {
        return $list = $value;

    }


}