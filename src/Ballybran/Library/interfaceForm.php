<?php
/**
 * KNUT7 K7F (http://framework.artphoweb.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */
/**
 * Form Helper
 *
 */


/**
 * Create form elements quickly.
 */

/**
 * open form
 *
 * This method return the form element <form...
 *
 * @param   array(id, name, class, onsubmit, method, action, files, style)
 *
 * @return  string
 */

namespace Ballybran\Library;


interface interfaceForm
{

    public static function open($params = array());

    /**
     * closed the form
     *
     * @return string
     */
    public static function close();

    /**
     * textBox
     *
     * This method creates a textarea element
     *
     * @param   array(id, name, class, onclick, columns, rows, disabled, placeholder, style, value)
     *
     * @return  string
     */
    public static function textBox($params = array());

    /**
     * input
     *
     * This method returns a input text element.
     *
     * @param   array(id, name, class, onclick, value, length, width, disable,placeholder)
     *
     * @return  string
     */
    public static function input($params = array());

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
    public static function select($params = array());

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
    public static function checkbox($params = array());

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
    public static function radio($params = array());

    /**
     * This method returns a button element given the params for settings
     *
     * @param   array(id, name, class, onclick, value, disabled)
     *
     * @return  string
     */
    public static function button($params = array());

    /**
     * This method returns a submit button element given the params for settings
     *
     * @param   array(id, name, class, onclick, value, disabled)
     *
     * @return  string
     */
    public static function submit($params = array());

    /**
     * This method returns a hidden input elements given its params
     *
     * @param   array(id, name, class, value)
     *
     * @return  string
     */
    public static function hidden($params = array());

    /**
     * This method returns a table element given the params for settings
     *
     * @param [ 'thead' => [ 'a', 'b' ], 'tbody' => [ 'ax', 'bx'], 'class' =>  'xxxxxx', ] ;
     *
     * @return  string
     */
    public static function table($params = array());

    /**
     *
     * @since 1.0.6
     *
     * @param [ 'for' => 'exemplo-title' ], ['title' => 'Example Title' ];
     *
     * @return  string
     */

    public static function label($params = array());

}