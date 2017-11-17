[![Build Status](https://travis-ci.org/Knut7/Knut7.svg?branch=master)](https://travis-ci.org/Knut7/Knut7)
[![license](https://img.shields.io/github/license/Knut7/Knut7.svg)]()
[![Packagist](https://img.shields.io/packagist/v/Knut7/Knut7.svg)]()

/**
 *
 * knut7 Framework (http://framework.artphoweb.com/)
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2016.  knut7 Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 */






## OBS: Documentação a ser concluído
Sumário
Introdução	3
Criando o Projecto	4
Constantes	6
Controllers	7
Views	9
Models	10
Assets	16
Copyright	18
Form	19
Hook	21
Hash	22
Session	24




## Introdução
A Knut7 é um framework criado e mantida pelo Artphoweb para facilitar o rápido desenvolvimento de sistemas para qualquer desenvolvedor experiente ou não!!
Um framework para aplicações web é um framework de software designado para suportar o desenvolvimento de sites web dinâmicos, aplicações Web e serviços Web. O framework destina-se a aliviar a sobrecarga associada a atividades comuns realizadas em desenvolvimento Web.

Fonte: wikipedia

Ele é modular. Tudo se passa na pasta módulo. O grande benefício no knut7 é pelo facto dele ser totalmente modular. Você pode instalar um módulo em MVC pelo composer ou ainda mesmo remove-lo sem que haja complicações!!. Os módulos são totalmente substituíveis.!

A knut7- FRAMEWORK segue o padrão arquitetural Modelo Visão e Controller(MVC) que permitirá a reutilização do teu código sem muitas dificuldades. Ela possui a seguinte estrutura:

## Requisitos:
PHP v7.x
Conhecimentos básicos de php
Do resto é moleza.
Link pra contribuições e Download : https://github.com/aphra-frameworkaphra-framework





#Criando o Projecto

Existe um Diretório padrão na framewok que se chama Module. Dentro dela, você criara um outro diretório e renomeara dando o nome do teu projecto como mostra a fig 1.1. 

1 – Nome padrão da Framewok onde será colocado todos s projectos se chama Module
OBS Não alterar o nome.

2 – Nome do Projecto “Pessoa”

Fig 1: Criação do Projecto
 

2 . Configuração

Pra configurar a framework é simples. Vai ate ao Diretório Config (1) e altera os valores em branco das variáveis existente no arquivo Config.module.php

	•	Nome do Projecto. Ex. Pessoa

	•	Idioma do projecto (Padrão Inglês)


A knut7- FRAMEWORK segue o padrão arquitetural Modelo Visão e Controller(MVC), logo, a estrutura do teu projecto devera ficar da seguinte forma:



## Constantes



HEADER_TITLE -> Aponta ao titulo para o cabeçalho
HEADER_DESCRIPTION -> aponta ate  a descirção para o cabeçalho;
URL -> A URL serve para chamar o directório raiz;
HTTPS -> A URL serve para chamar o directório raiz. Use se saber o que esta a fazer; 
DIR_FILE -> Carrega o directório do projecto;
DIR_LANGUAGE -> aponta o ficheiro de tradução;
DIR_LOGS -> aponta o ficheiro de Log;

Constantes responsável pra criar códigos para criptografias 

```php

<?php

ALGO;
HASH_KEY;
AUTH_KEY;
SECURE_AUTH_KEY;
LOGGED_IN_KEY;
NONCE_KEY;
AUTH_SALT;
SECURE_AUTH_SALT;
LOGGED_IN_SALT;
NONCE_SALT;
Ballybran_CACHE;


?>
```

## Controllers
Index


class index exteds Controller

Class index

Methods
index é um método padrão que todos o controllers deverão ter.
index( void)

### Exemplo:
 ```php


use  \Ballybran\Core\Controller\AbstractController;

class index extends AbstractControllerController {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        
     
    }
}


```


Titile
Para adicionar um titulo ao teu projecto dinamicamente, você devera:

	•	No arquivo html.phtml devra colocar :

```php

<title><?php $title = $this->title ?? "FW APP" ?></title> 
``` 
e em seguida no teu controller inserir o codigo abaixo:
	•	$this->view->title = "Artigos";




Views
View
class View implements iView


Class View
BrowserRedirect render( $controller, string $view)
controller
$controller

istring
$view


Parameters
Return Value
Redireciona para vista

Exemplo:
 ```php

use  \Ballybran\Core\Controller\AbstractController;

class index extends AbstractController {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        
        $this->view->render($this, 'index');
    }
}

```
## Models

A classe Model  terá que ter o mesmo nome do seu ficheiro php. 
O ficheiro php para o model devera ter na sua parte final o nome Model
Por exemplo. pessoModel.php onde pessoa é o nome da class  e o Model o nome do Model


Class Model
__construct( iDatabase $entity)

Parameters
interface
Implements

iDatabase




Exemplo:
 ```php

use Ballybran\Database\Drives\AbstractDatabaseInterface;
class indexModel {

    private $entity;

    private $db;
    public function __construct(AbstractDatabaseInterface $entity ) {
        $this-> entity = $entity;
    }

}


```
Details
__construct( AbstractDatabaseInterface $entity) 


usando a PROPRIEDADE $entity
Methods
string
$this->entity->update($table, $data, $where )
save Fungsi untuk menambah atau mengupdate record (Insert/Update)

string

```php

$this->entity->delete($table, $where, $limit )
```
static array

```php

$this->entity->select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC
);
```
find function for select query

```php

$this->entity->insert($table, $data)
?>
```

No description

Details

string
SQL Query

select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
find function for select query
Parameters

sql
$sql
“select, where, join, limit, order”etc
array
$array
optional
fetchMode
$ fetchMode
PDO::FETCH_ASSOC e outros

Exemplo:

 ```php
  
public function _getArticleById($id) {
    
    return $this->entity->select("SELECT * FROM article WHERE id_article =" . $id);
}

```

insert($table, $data)
Parameters
table
$table
array
$ata

Exemplo:
 ```php
 

 public function insertArticle($data) {
    return $this->entity->insert('article', $data);
 }
delete($table, $where, $limit)

```
Return Value
string
Table name
string
SQL Query
Int 
Default limit 1

Exemplo:
 ```php
 

public function deleteArticle($id) {
    return $this->entity->delete('article', "id_article=$id", 1);
}


update($table, $data, $where)

```

Return Value
string
Table name
array
$data
string 
SQL Query


Exemplo :
 ```php
 
public function editPublish($data, $id) {
    return $this->entity->update('article', $data, "id_article=$id");
}

```

Methods

LoadModel

O method LoadModel é chamada pelas classes Controllers do projecto atraves da propriedade $this->model que acessa o Method das classes Model do Teu projecto.

Exemplo:

##Class Controller index 
 ```php

class Article extends Controller {
  
    public $public;
    public function __construct() {
        parent::__construct();
        
    }
  
    public function index() {
        $this->view->title = "Artigos";
        /** @var int $id */
        $this->view->public = $this->model->_getAllArticle();
        $this->view->render($this, 'index');
      
    }
}


class ArticleModel {
    private $entity;
    public function __construct(iDatabase $entity) {
        $this->entity = $entity;
    }
   
    public function _getAllArticle() {
        
        return $this->entity->select("SELECT * FROM article "
    }

```


Assets



class Assets
Methods

static js( Array $files $view)
No description
static css( Array $files

Details
static js( Array $files )
Parameters
Array
$files
Carrega ficheiros js

static css( Array $files )
Parameters
Array
$files
Carrega ficheiros css
Return Value

Exemplo:
 ```php
 
 echo Assets::js([ URL . 'Public/js/bootstrap.js', URL . "Public/bootstrap/js/bootstrap-theme.min.js", URL . "Public/bootstrap/js/bootstrap.min.js",  DIR_FILE . 'Public/js/myStyle.js']); 

Assets::css([ URL . 'Public/css/bootstrap.css', URL . "Public/bootstrap/css/bootstrap-theme.min.css", URL . "Public/bootstrap/css/bootstrap.min.css",  DIR_FILE . 'Public/css/myStyle.css']); ?>


```



Copyright





 class Copyright
Methods

static copyrigt( int $data_last , String $name )
No description
Details
static copyrigt( int $data_last , String $name )
Parameters

int
$data_last
string
$name

Exemplo:
```php
<footer class="footer panel-footer ">
   echo  Copyright::copyright(2015, 'knut7 FRAMWORK'); ?>
</footer>

```


Hook

 class Hook
Methods

static Header( $header )
No description

Details
static Header( $header )
Parameters



string
$header

Exemplo:

 ```php

public function deleteArticle($id) {
    if (Session::exist()) {
        if (Session::get('role') == 'owner') {
            $this->model->deleteArticle($id);
            Hook::Header('article/publish');
        }
    } else {
        Hook::Header('');
    }
}

```




Hash
class Hash
Methods

```php

static Create( $algo, $data, $salt )
``` 
No description

```php
static token( $length = 32 )

``` 


Details
static Header( $header )
Parameters

static Create( $algo, $data, $salt)
Constante
algo
MD5
String
data
Dado a ser criptografado 
String
salt
hash keys

Exemplo:

 ```php

public function signUp() {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $data['firstname'] = Ucfirst::_ucfirst(htmlspecialchars($_POST['firstname']));
        $data['lastname'] = Ucfirst::_ucfirst(htmlspecialchars($_POST['lastname']));
        $data['username'] = htmlspecialchars($_POST['username']);
        $data['email'] = $_POST['mail'];
        $data["password"] = Hash::Create(ALGO, $_POST["password"], HASH_KEY);
        echo $this->model->signUp($data);
    }
    $this->view->render($this, 'register');
}


```



Session

class Session
Methods

static init( )
No description
static set( $key, $value )
No description
static get( $key )
No description
static Destroy( )
No description

static exists( )
No description
static handleLogin( )

Details
Parameters

static init( )

VOID

static set( $key, $value )
string
$key
string
$value

Exemplo de uma function para a Criação de uma Session
 ```php

public function CreateSession($username, $role, $id) {
    Session::set('U_NAME', $username);
    Session::set('role', $role);
    Session::set('ID', $id);
}
static get( $key )

static Destroy( )

?>
```
void


Exemplo de uma function de Destruição de uma Session

 ```php
public function DestroySession() {
    Session::Destroy();
    Hook::Header('');
}
static exists( )


```
void
 ```php
public function Cpanel() {
    if (Session::exist()) {
        $title = $this->view->title = "Cpanel";
        $this->view->c = $this->model->getImage(Session::get("ID"));
        if ($this->model->getImageUser(Session::get("ID") == true)) {
            $this->view->UserPhoto = $this->model->getImageUser(Session::get("ID"))[0];
        }
        $this->view->render($this, 'cpanel');
    } else {
        Hook::Header('account/profile');
    }
}

static handleLogin( )

```
void



