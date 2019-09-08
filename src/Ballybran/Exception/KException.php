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

namespace Ballybran\Exception;

use Ballybran\Helpers\Utility\Assets;


class KException {


public static function createPathInModelo()
{

    PageError::Auth("Se estas a ver esta mensagem é sinal de que o directório padrão <code>Applications</code> não se encontra dentro do <code>Module</code>. Para corrigir este erro faça o seguinte: <br/><br/>1 . A pasta para a aplicação por padrão é o <code>Applications</code>. Se não existe ou se quer criar uma  <br/>
  pasta  nova para a tua aplicação então você pode cria uma pasta para a tua aplicação em <code>" . PV . "</code><br/>
  Exemplo:<br/><br/>
  <code>" . PV . "MINHA APLICACÃO;</code><br/><br/>
  2 Na pasta <code>Config</code> no ficheiro <code>Config.module.php</code> insere o nome da tua <code>aplicação</code> na variavel <code>$<en>MY_PROJECT_NAME</code><br/>
  Exemplo:<br/><br/>
  <code>$<en>MY_PROJECT_NAME = 'MINHA APLICACÃO';</code><br/><br/> ");
}

public static function createController($classFile , $controllerPath)
{

    PageError::Auth("3 . O Controllador <code>$classFile.php</code>  nao existe. Cria um novo directorio e nomeie por <code>Controllers</code>.<br/><br/> Em seguida dentro deste novo directório <code>Controllers</code> insere o controllador <code>$classFile.php</code>. E por ultimo,  cole o codigo de baixo no <code>$classFile.php</code><br/>
       exemplo:<br/><code>$controllerPath</code><br/>
        ----------<br/><code><? php <br/>class $classFile { <br/><br/>public function __construct()\n{<br/><br/># code...<br/>}<br/><br/>public function Index(){<br/><br/>}<br/>}</code><br/>----------");
}

public static function controller($classFile)
{

    PageError::Auth("<p class='btn btn-danger>' 3 . A class nao exise. Você deve criar em primeiro lugar uma classe em <code>$classFile</code>.'</p>' ");
}

public static function indexController($classFile)
{

    PageError::Auth("<br/> 4 Você deve criar uma propriedade Index na tua classe <code>$classFile </code>");
}

public static function noPathView()
{

    PageError::Auth("<br/>Não foi criado A pasta View em <code>" . APP . "</code> ");
}

public static function noPathinView($viewPath)
{

    PageError::Auth("<br/> Não foi criado o <code>directório $viewPath</code>  dentro da pasta View em <code>" . APP . "</code> ");
}

public static function notHeader()
{

    PageError::no("<br/>Não foi criado o arquivo <code>header.phtml</code> na pasta View ");
}

public static function notFooter()
{

    PageError::no("<br/>Não foi criado o arquivo <code>footer.phtml</code> na pasta view");
}

public static function notIndex($viewPath)
{

    PageError::no("<br/>Não foi criado o arquivo <code>Index.phtml</code> no <code>directório $viewPath em View</code>");
}

public static function notFound()
{

    self::error();
}

public static function langNotLoad()
{
    echo "Could not load language file";
}

public static function getMessage($message)
{
    echo $message;
}
public static function error($params = null){ ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>404</title>
    <link rel="stylesheet" href="<?php echo URL; ?>Public/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo URL; ?>Public/css/bootstrap-theme.min.css"/>

</head>
<script src="<?php echo URL; ?>Public/bootstrap/jQuery.js"></script>


<body>
<!-- Navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <p class="navbar-brand">knut7</p>
        </div><!-- End Navbar Header -->

        <div class="collapse navbar-collapse" id="navbar-collapse">

            <ul class="nav navbar-nav">
                <!-- <li><a href="<?php /* echo URL; */ ?>index">HOME</a> </li> -->

            </ul>
        </div>
    </div><!-- End Conteiner -->
</nav><!-- End Navbar -->

<br/><br/><br/>
<div class="container content">
    <div class="row">
        <div class="col-md-12">

            <h1>404</h1>


            <hr/>

            <h3>The page you were looking for could not be found</h3>
            <p>This could be the result of the page being removed, the name being changed or the page being temporarily
                unavailable</p>
            <h3>Troubleshooting</h3>

            <ul>
                <li>If you spelled the URL manually, double check the spelling</li>
                <li>Go to our website's home page, and navigate to the content in question</li>
            </ul>

            <hr>

            <?php

            if (is_array($params)) {
                echo "<div class=\"well\">";
                foreach ($params as $k => $v) {
                    echo "<ul>";
                    echo "<li>" . $k . " :::::::::::: " . $v . "</li>";
                    echo "</ul>";

                }
                echo "</div>";

            } else if ($params) {
                echo "<div class=\"well\">";
                echo $params;
                echo "</div>";

            } else if (class_exists($params)) {

            } ?>

        </div>

    </div>
</div>
</div>
<?php
}
}
?>
</body>
</html>

