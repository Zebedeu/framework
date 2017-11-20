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
 * @property
 */

namespace Ballybran\Core\Controller;
use Ballybran\Core\Model\Model;
use Ballybran\Core\View\View;
use Ballybran\Helpers\Language;
use Ballybran\Helpers\Uploads;
use Ballybran\Helpers\Security\Session;

/**
 */
   class AbstractController extends Model implements AbstractControllerInterface
  {

      /**
       * @var View
       */
      protected $view;
      /**
       * @var Uploads
       */
      protected $imagem;


       /**
        * @var
        */
       protected $width;
       /**
        * @var
        */
       protected $height;
       /**
        * @var
        */
       protected $quality;
       /**
        * @var
        */
       protected $option;
       public $language;


       /**
       * AbstractController constructor.
       *  call method function  init
       * View view estancia a class view
       * call method LoadeModel();
       */
        public function __construct()
      {

          parent::__construct();
          Session::init();

          $this->view = new View();
          $this->imagem = new Uploads();
          $this->language = new Language();
          $this->demensionOfImage();

      }

       public function demensionOfImage() {
          $this->imagem->setWidth($this->width);
          $this->imagem->setHeight($this->height);
          $this->imagem->setQuality($this->quality);
          $this->imagem->setOption($this->option);
      }

  }