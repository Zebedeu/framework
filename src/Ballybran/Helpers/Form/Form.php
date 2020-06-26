<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */


namespace Ballybran\Helpers\Form;

/**
 * Create form elements quickly.
 */
class Form implements interfaceForm
{

    /**
     * open form
     *
     * This method return the form element <form...
     *
     * @param   array(id, name, class, onsubmit, method, action, files, style)
     *
     * @return  string
     */
    public static function open($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }
        $o = '<form';
        $o .= (isset($params['id'])) ? " id='{$params['id']}'" : '';
        $o .= (isset($params['onsubmit'])) ? " onsubmit='{$params['onsubmit']}'" : '';
        $o .= (isset($params['method'])) ? " method='{$params['method']}'" : ' method="get"';
        $o .= (isset($params['action'])) ? " action='{$params['action']}'" : '';
        $o .= (isset($params['files'])) ? " enctype='multipart/form-data'" : '';
        $o .= (isset($params['role'])) ? " role='{$params['role']}'" : '';
        $o .= (isset($params['novalidate'])) ? " {$params['novalidate']}" : '';
        $o .= '>';
        return $o;
    }

    /**
     * closed the form
     *
     * @return string
     */
    public static function close()
    {
        return "</form>\n";
    }

    /**
     * textBox
     *
     * This method creates a textarea element
     *
     * @param   array(id, name, class, onclick, columns, rows, disabled, placeholder, style, value)
     *
     * @return  string
     */
    public static function textBox($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }
        $o = '<textarea';
        $o .= self::param_mix($params);
        $o .= (isset($params['cols'])) ? " cols='{$params['cols']}'" : '';
        $o .= (isset($params['rows'])) ? " rows='{$params['rows']}'" : '';
        $o .= (isset($params['maxlength'])) ? " maxlength='{$params['maxlength']}'" : '';
        $o .= '>';
        $o .= (isset($params['value'])) ? $params['value'] : '';
        $o .= "</textarea>\n";
        return $o;
    }

    /**
     * input
     *
     * This method returns a input text element.
     *
     * @param   array(id, name, class, onclick, value, length, width, disable,placeholder)
     *
     * @return  string
     */
    public static function input($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }

        $o = '<input ';
        $o .= self::param_mix($params);
        $o .= (isset($params['onkeypress'])) ? " onkeypress='{$params['onkeypress']}'" : '';
        $o .= (isset($params['length'])) ? " maxlength='{$params['length']}'" : '';
        $o .= (isset($params['accept'])) ? " accept='{$params['accept']}'" : '';
        $o .= (isset($params['maxlength'])) ? " maxlength='{$params['maxlength']}'" : '';
        $o .= (isset($params['minlength'])) ? " minlength='{$params['minlength']}'" : '';
        $o .= (isset($params['autocomplete'])) ? " autocomplete='{$params['autocomplete']}'" : '';
        $o .= (isset($params['autofocus'])) ? " autofocus" : '';
        $o .= " />\n";
        return $o;
    }

    /**
     * select
     *
     * This method returns a select html element.
     * It can be given a param called value which then will be preselected
     * data has to be array(k=>v)
     *
     * @param   array(id, name, class, onclick, disabled)
     *
     * @return  string
     */
    public static function select($params = array())
    {
        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }

        $o = "<select";
        $o .= self::param_mix($params);
        $o .= (isset($params['width'])) ? " style='width:{$params['width']}px;'" : '';
        $o .= ">\n";
        $o .= "<option value=''>Select</option>\n";
        if (isset($params['data']) && is_array($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                if (isset($params['value']) && $params['value'] == $k) {
                    $o .= "<option value='{$k}' selected='selected'>{$v}</option>\n";
                } else {
                    $o .= "<option value='{$k}'>{$v}</option>\n";
                }
            } 
        
            throw new \InvalidArgumentException("Arguments is not valid " . print_r($params, true));

            
        }
        $o .= "</select>\n";
        return $o;
    }

    /**
     * checkboxMulti
     *
     * This method returns multiple checkbox elements in order given in an array
     * For checking of checkbox pass checked
     * Each checkbox should look like array(0=>array('id'=>'1', 'name'=>'cb[]', 'value'=>'x', 'label'=>'label_text' ))
     *
     * @param   array(array(id, name, value, class, checked, disabled))
     *
     * @return  string
     */
    public static function checkbox($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }
        $o = '';
        $x = 0;
        foreach ($params as $k => $v) {
            $v['id'] = (isset($v['id'])) ? $v['id'] : "cb_id_{$x}_" . rand(1000, 9999);
            $o .= "<input type='checkbox'";
            $o .= self::param_mix($params);
            $o .= (isset($v['checked'])) ? " checked='checked'" : '';
            $o .= (isset($v['disabled'])) ? " disabled='{$v['disabled']}'" : '';
            $o .= " />\n";
            $o .= (isset($v['label'])) ? "<label for='{$v['id']}'>{$v['label']}</label> " : '';
            $x++;
        }

        return $o;
    }

    /**
     * radioMulti
     *
     * This method returns radio elements in order given in an array
     * For selection pass checked
     * Each radio should look like array(0=>array('id'=>'1', 'name'=>'rd[]', 'value'=>'x', 'label'=>'label_text' ))
     *
     * @param   array(array(id, name, value, class, checked, disabled, label))
     *
     * @return  string
     */
    public static function radio($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }

        $o = '';
        $x = 0;
        foreach ($params as $k => $v) {
            $v['id'] = (isset($v['id'])) ? $v['id'] : "rd_id_{$x}_" . rand(1000, 9999);
            $o .= "<input type='radio'";
            $o .= self::param_mix($params);
            $o .= (isset($v['checked'])) ? " checked='checked'" : '';
            $o .= (isset($v['disabled'])) ? " disabled='{$v['disabled']}'" : '';
            $o .= " />\n";
            $o .= (isset($v['label'])) ? "<label for='{$v['id']}'>{$v['label']}</label> " : '';
            $x++;
        }

        return $o;
    }

    /**
     * This method returns a button element given the params for settings
     *
     * @param   array(id, name, class, onclick, value, disabled)
     *
     * @return  string
     */
    public static function button($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }

        $o = "<button type='submit'";
        $o .= self::param_mix($params);
        $o .= (isset($params['onclick'])) ? " onclick='{$params['onclick']}'" : '';
        $o .= ">";
        $o .= (isset($params['class'])) ? "<i class='fa {$params['iclass']}'></i> " : '';
        $o .= "</button>\n";
        return $o;
    }

    /**
     * This method returns a submit button element given the params for settings
     *
     * @param   array(id, name, class, onclick, value, disabled)
     *
     * @return  string
     */
    public static function submit($params = array())
    {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }

        $o = '<input type="submit"';
        $o .= self::param_mix($params);
        $o .= (isset($params['onclick'])) ? " onclick='{$params['onclick']}'" : '';
        $o .= " />\n";
        return $o;
    }

    /**
     *
     * @since 1.0.6
     *
     * @param array
     *
     * @return  string
     */

    private static function param_mix($params = array()) {

        if (!is_array($params)) {
            throw new \InvalidArgumentException("Arguments is not a Array" . print_r($params, true));
        }
        $o ='';
        $o .= (isset($params['id'])) ? " id='{$params['id']}'" : '';
        $o .= (isset($params['name'])) ? " name='{$params['name']}'" : '';
        $o .= (isset($params['class'])) ? " class='form-input textbox {$params['class']}'" : '';
        $o .= (isset($params['onclick'])) ? " onclick='{$params['onclick']}'" : '';
        $o .= (isset($params['disabled'])) ? " disabled='{$params['disabled']}'" : '';
        $o .= (isset($params['required'])) ? " required='required'" : '';
        $o .= (isset($params['type'])) ? " type='{$params['type']}'" : 'type="text"';
        return $o;

    }
    public static function label($params = array())
    {
        $o = "<label";
        $o .= (isset($params['for'])) ? " for='{$params['for']}'" : '';
        $o .= (isset($params['class'])) ? " class='{$params['class']}'" : '';
        $o .= '>';
        $o .= (isset($params['title']) ? $params['title'] : " ");
        $o .= '</label>';

        return $o;
    }

}
