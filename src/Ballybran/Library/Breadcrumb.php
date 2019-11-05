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

namespace Ballybran\Library;

class Breadcrumb
{

    private $default = 'portugese';
    private $title;
    private $options = array();

    public function breadcrumb($options)
    {

        $this->options = array(
            'before' => '<span class="arrow">',
            'after' => '</span>',
            'delimiter' => '&raquo;'
        );

        if (is_array($options)) {
            return $this->options = array_merge($this->options, $options);
        }

        return $markup = $this->options['before'] . $this->options['delimiter'] . $this->options['after'];

        global $post;
        echo '<p class="breadcrumb"><a href="' . URL . '">';
        echo '</a>';
    }

}
