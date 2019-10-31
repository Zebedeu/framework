[![Build Status](https://travis-ci.org/knut7/knut7.svg?branch=master)](https://travis-ci.org/Knut7/Knut7)
[![license](https://img.shields.io/github/license/Knut7/Knut7.svg)]()
[![Packagist](https://img.shields.io/packagist/v/Knut7/Knut7.svg)]()

/**
 *
 * knut7 Framework (http://knut7.com)
 *
 * @link      http://github.com/knut7/knut7 for the canonical source repository
 * @copyright (c) 2016.  MACHIZE Technologies AO Inc. (http://knut7.com)
 * @license   http://knut7.com/license/new-bsd New BSD License
 */




## Introdução
A Knut7 é um framework criado e mantida pelo MACHIZE para facilitar o rápido desenvolvimento de sistemas para qualquer desenvolvedor experiente ou não!!
Um framework para aplicações web é um framework de software designado para suportar o desenvolvimento de sites web dinâmicos, aplicações Web e serviços Web. O framework destina-se a aliviar a sobrecarga associada a atividades comuns realizadas em desenvolvimento Web.

Fonte: wikipedia

Ele é modular. Tudo se passa na pasta módulo. O grande benefício no knut7 é pelo facto dele ser totalmente modular. Você pode instalar um módulo em MVC pelo composer ou ainda mesmo remove-lo sem que haja complicações!!. Os módulos são totalmente substituíveis.!

A knut7- FRAMEWORK segue o padrão arquitetural Modelo Visão e Controller(MVC) que permitirá a reutilização do teu código sem muitas dificuldades. Ela possui a seguinte estrutura:

## Requisitos:
PHP v7.x
Conhecimentos básicos de php
Do resto é moleza.

Link pra contribuições e Download : https://github.com/knut7 && https://github.com/knut7/framework




# Instalação

composer create-project --prefer-dist knut7/knut7 site

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

## Basic Controller

```php


namespace App\HttpControllers;


use Ballybran\Core\Controller\AbstractController;

class Index extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->view->title = "Welcome!!!";
    	$this->view->render($this, 'index');
    }

}
```

## Basic Views


## View

	 
	  	
	  render Renders the view using the given data
	  Example:
	 
```php
  
	   $v = new View('view');
	   $v->render(array('title' => 'My view'));
	  
```

	  fetch Fetches the view result intead of sending it to the output buffer
	 
	  Example:
	 
```php
  
	   $v = new View('view');
	   $content = $v->fetch(array('title' => 'My view'));
	  
```

	  get_data Returns the view data
	 
	  Example:
	 
	  run.php
 
```php
	  
	   $v = new View('view');
	   $v->render();
	   $data = $v->get_data();
	   echo $data['response'];
	  
```	 
	  view.php

```php
  
	   $this['response'] = 'Hello';
	  

```
	
	  include_file Used by view to include sub-views
	 
	  Example:
	 
	  index.phtml
```php
	  
	   <html>
	   <body>
	     body content
	     <?php $this->include_file('footer') ?>
	   </body>
	   </html>
	  
```


	  set_layout Used by view to indicate the use of a layout.
	 
	  If a layout is selected, the normal output of the view wil be
	  discarded.  The only way to send data to the layout is via
	  capture()
	 
	  Example:
	 
	  main_view.phhtml

```php

	  $this->set_layout('layout')
	   $this->capture() 
	     body content
	   $this->end_capture('body') 
	  
 ```

	  layout.phtml

```php
	  
	   <html>
	   <body>
	     <?php echo $this['body'] ?>
	     <?php $this->include_file('footer') ?>
	   </body>
	   </html>
	  
```
	 
	
	  capture Used by view to capture output.
	 
	  When a view is using a layout (via set_layout()), the only way to pass
	  data to the layout is via capture(), but the view can use capture()
	  to capture text any time, for any reason, even if the view is not using
	  a layout
	 
	  Example:
	 

	  run.php
```php	  
	   $v = new View('index');
	   $v->render();
	   $data = $v->get_data();
	   echo $data['response'];
	  
``` 
	  index.phtml
```php	  
	   <?php $this->capture() ?>
	     captured content
	   <?php $this->end_capture('response') ?>
	  

```

	  end_capture Used by view to signal end of a capture().
	 
	  The content of the capture is stored under $name
	 
	  Example:


	  run.php

```php  
	   $v = new View('index');
	   $v->render();
	   $data = $v->get_data();
	   echo $data['response'];

```
	 
	  index.phtml

```php  
	   <?php $this->capture() ?>
	     captured content
	   <?php $this->end_capture('response') ?>
	  
```


	  ArrayAccess methods

 
	  Examples:
	 
	  view.php
```php	  
	   <?php echo $this['title'] ?>
	   <?php $this['foo'] = 'bar' ?>
	  
```


 ## In Controller
```php 

        $data['data'] = ['telephone' => 913000000];
        return (new View() )->render($this , 'index', $data);

```
 ## In View - get data

```php

        echo ($this->dot->get("data.telephone"));

 ```

## Acess database in Model

```php

use \Ballybran\Database\Drives\AbstractDatabaseInterface;
class IndexModel{

    private $database;
    
    public function __construct(AbstractDatabaseInterface $database) {
        $this->database = $database;
    }
    
    public function getAllContacts(){
        return $this->database->find("Contacto", "*");
    }
}

use Ballybran\Core\Controller\AbstractController;
use Ballybran\Core\View\View;

class Index extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->title = "Home";
        $data['data'] = $this->model->getAllContacts();
        return (new View() )->render($this , 'index', $data);
    }
    

}

```
index.php View

```php
    echo ($this->dot->get("data.telephone"));

```
## Examples

With Dot you can chage this regular array syntax:

```php
$array['info']['home']['address'] = 'Kings Square';

echo $array['info']['home']['address'];

// Kings Square
```

to this (Dot object):

```php
$dot->set('info.home.address', 'Kings Square');

echo $dot->get('info.home.address');
```

or even this (ArrayAccess):

```php
$dot['info.home.address'] = 'Kings Square';

echo $dot['info.home.address'];
```

## Install

Install the latest version using [Composer](https://getcomposer.org/):

```
$ composer require adbario/php-dot-notation
```

## Usage

Create a new \IteratorDot object:

```php
$dot = new \IteratorDot;

// With existing array
$dot = new \IteratorDot($array);
```

You can also use a helper function to create the object:
```php
$dot = dot();

// With existing array
$dot = dot($array);
```

## Methods

Dot has the following methods:

- [add()](#add)
- [all()](#all)
- [clear()](#clear)
- [count()](#count)
- [delete()](#delete)
- [flatten()](#flatten)
- [get()](#get)
- [has()](#has)
- [isEmpty()](#isEmpty)
- [merge()](#merge)
- [pull()](#pull)
- [push()](#push)
- [set()](#set)
- [setArray()](#setArray)
- [setReference()](#setReference)
- [toJson()](#toJson)

<a name="add"></a>
### add()

Sets a given key / value pair if the key doesn't exist already:
```php
$dot->add('user.name', 'John');

// Equivalent vanilla PHP
if (!isset($array['user']['name'])) {
    $array['user']['name'] = 'John';
}
```

Multiple key / value pairs:
```php
$dot->add([
    'user.name' => 'John',
    'page.title' => 'Home'
]);
```

<a name="all"></a>
### all()

Returns all the stored items as an array:
```php
$values = $dot->all();
```

<a name="clear"></a>
### clear()

Deletes the contents of a given key (sets an empty array):
```php
$dot->clear('user.settings');

// Equivalent vanilla PHP
$array['user']['settings'] = [];
```

Multiple keys:
```php
$dot->clear(['user.settings', 'app.config']);
```

All the stored items:
```php
$dot->clear();

// Equivalent vanilla PHP
$array = [];
```

<a name="count"></a>
### count()

Returns the number of items in a given key:
```php
$dot->count('user.siblings');
```

Items in the root of Dot object:
```php
$dot->count();

// Or use coun() function as Dot implements Countable
count($dot);
```

<a name="delete"></a>
### delete()

Deletes the given key:
```php
$dot->delete('user.name');

// ArrayAccess
unset($dot['user.name']);

// Equivalent vanilla PHP
unset($array['user']['name']);
```

Multiple keys:
```php
$dot->delete([
    'user.name',
    'page.title'
]);
```

<a name="flatten"></a>
### flatten()

Returns a flattened array with the keys delimited by a given character (default "."):
```php
$flatten = $dot->flatten();
```

<a name="get"></a>
### get()

Returns the value of a given key:
```php
echo $dot->get('user.name');

// ArrayAccess
echo $dot['user.name'];

// Equivalent vanilla PHP < 7.0
echo isset($array['user']['name']) ? $array['user']['name'] : null;

// Equivalent vanilla PHP >= 7.0
echo $array['user']['name'] ?? null;
```

Returns a given default value, if the given key doesn't exist:
```php
echo $dot->get('user.name', 'some default value');
```

<a name="has"></a>
### has()

Checks if a given key exists (returns boolean true or false):
```php
$dot->has('user.name');

// ArrayAccess
isset($dot['user.name']);
```

Multiple keys:
```php
$dot->has([
    'user.name',
    'page.title'
]);
```

<a name="isEmpty"></a>
### isEmpty()

Checks if a given key is empty (returns boolean true or false):
```php
$dot->isEmpty('user.name');

// ArrayAccess
empty($dot['user.name']);

// Equivalent vanilla PHP
empty($array['user']['name']);
```

Multiple keys:
```php
$dot->isEmpty([
    'user.name',
    'page.title'
]);
```

Checks the whole Dot object:
```php
$dot->isEmpty();
```

<a name="merge"></a>
### merge()

Merges a given array or another Dot object:
```php
$dot->merge($array);

// Equivalent vanilla PHP
array_merge($originalArray, $array);
```

Merges a given array or another Dot object with the given key:
```php
$dot->merge('user', $array);

// Equivalent vanilla PHP
array_merge($originalArray['user'], $array);
```

<a name="pull"></a>
### pull()

Returns the value of a given key and deletes the key:
```php
echo $dot->pull('user.name');

// Equivalent vanilla PHP < 7.0
echo isset($array['user']['name']) ? $array['user']['name'] : null;
unset($array['user']['name']);

// Equivalent vanilla PHP >= 7.0
echo $array['user']['name'] ?? null;
unset($array['user']['name']);
```

Returns a given default value, if the given key doesn't exist:
```php
echo $dot->pull('user.name', 'some default value');
```

Returns all the stored items as an array and clears the Dot object:
```php
$items = $dot->pull();
```

<a name="push"></a>
### push()

Pushes a given value to the end of the array in a given key:
```php
$dot->push('users', 'John');

// Equivalent vanilla PHP
$array['users'][] = 'John';
```

Pushes a given value to the end of the array:
```php
$dot->push('John');

// Equivalent vanilla PHP
$array[] = 'John';
```

<a name="set"></a>
### set()

Sets a given key / value pair:
```php
$dot->set('user.name', 'John');

// ArrayAccess
$dot['user.name'] = 'John';

// Equivalent vanilla PHP
$array['user']['name'] = 'John';
```

Multiple key / value pairs:
```php
$dot->set([
    'user.name' => 'John',
    'page.title'     => 'Home'
]);
```

<a name="setArray"></a>
### setArray()

Replaces all items in Dot object with a given array:
```php
$dot->setArray($array);
```

<a name="setReference"></a>
### setReference()

Replaces all items in Dot object with a given array as a reference and all future changes to Dot will be made directly to the original array:
```php
$dot->setReference($array);
```

<a name="toJson"></a>
### toJson()

Returns the value of a given key as JSON:
```php
echo $dot->toJson('user');
```

Returns all the stored items as JSON:
```php
echo $dot->toJson();
```

## Painator
Using The Paginator
```php
$page = new Paginator('PDO', "SELECT * FROM category inner join article on category.id_cat = article.id_cat WHERE category.name ='$this->nameOfTheCategorie' ORDER BY category.name DESC", 6);
```
show Pagination Links
```php
echo $page->createLinks('pagination' ); 
```


## Event Handler

```php
class MyEventClass
{
    private $events;
    private $eventHandlers;

    public function __construct(InterfaceEventCollection $events, InterfaceEventHandlerCollection $handlers
= null)
    {
        $this->events = $events;

        if ($handlers) {
            $this->eventHandlers = $handlers;
        } else {
            $this->eventHandlers = new EventHandlerCollection();
        }


    public function __destruct()
    {
        $this->triggerEvent('onUnload', array('arg2' => 2));
    }

    public function registerEventHandler($handler)
    {
        if ($this->events->contains($handler->getEventName())) {
            $this->eventHandlers->add($handler);
        }
    }

  public function notify($listEventName)
    {
        if (is_array($listEventName)) {
            foreach ($listEventName as $eventName) {
                $this->events->add(new Event($eventName));
            }
        } else {
            $this->events->add(new Event($eventName));
        }
    }
    
    public function triggerEvent($eventName, $args)
    {
        $this->eventHandlers->raiseEvent($eventName, $this,
$args);
    }
}

$handlers = new EventHandlerCollection();
$handlers->add(new EventHandler(new Event('onLoad'),
'handleLoad'));
$handlers->add(new EventHandler(new Event('onUnload'),
'handleUnload'));

echo $handlers->add(new EventHandler(new Event('carro'), 'on'));
echo $obj = new MyEventClass(new EventCollection(), $handlers);
echo $obj->registerEventHandler(new EventHandler(new Event('carro'), function () {
}));


```

## Example 2

```php

class MyEventClass2 implements InterfaceEventClass
{
    private $events;
    private $eventHandlers;

    public function __construct(InterfaceEventCollection $events, InterfaceEventHandlerCollection $handlers = null)
    {
        $this->events = $events;

        if ($handlers) {
            $this->eventHandlers = $handlers;
        } else {
            $this->eventHandlers = new EventHandlerCollection();
        }
    }

    public function notify($listEventName)
    {
        if (is_array($listEventName)) {
            foreach ($listEventName as $eventName) {
                $this->events->add(new Event($eventName));
            }
        } else {
            $this->events->add(new Event($eventName));
        }
    }

    public function triggerEvent($eventName, $args)
    {
        $this->eventHandlers->raiseEvent($eventName, $this,
$args);
    }
}

$handlers2 = new EventHandlerCollection();
echo $handlers2->add(new EventHandler(new Event('onLoad'), 'handleLoad'));
$obj2 = new MyEventClass2(new EventCollection(), $handlers2);
echo $obj2->notify(['onLoad']);
echo $obj2->triggerEvent('onLoad', ['args3' => 43]);

function handleLoad($sender, $args)
{
    echo 'object '.get_class($sender).' loaded with '.count($args).' args!<br />';
}

function handleUnload($sender, $args)
{
    echo 'object '.get_class($sender).' unloaded with '.count($args).' args!';
}
```

## HZIP

# create
```php

$zip = new HZip(new \ZipArchive());
echo $zip->create($limit = 500, $source = null, $destination = './');
```
# unzip

```php

$zip = new HZip(new \ZipArchive());
$zip->unzip($source, $destination);
```


## Hydractor Converte

```php
$hydra = HydractorConverte::toArry( array, object)
$hydra = HydractorConverte::toObject(object)
 
 ```
#Example 

```php


class Person
{
    private $id;
    private $firstname;
    private $lastname;
    private $username;
    private $email;
    private $password;

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = ValidateTypes::getSQLValueString(Ucfirst::_ucfirst($firstname), 'text');
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = ValidateTypes::getSQLValueString(Ucfirst::_ucfirst($lastname), 'text');
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
    public function setUsername($username)
    {
        $this->username = ValidateTypes::getSQLValueString($username, 'text');
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = ValidateTypes::getSQLValueString($email, 'email');
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
    public function setPassword($password)
    {
        $this->password = Hash::hash_password($password, PASSWORD_DEFAULT);
    }

 
$data['id'] = $_POST['id'];
$data['firstname'] = $_POST['firstname'];
$data['lastname'] = $_POST['lastname'];
$data['username'] = $_POST['username'];
$data['email'] = $_POST['email'];
$data['password'] = $_POST['password'];

$obj = HydractorConverte::toArry( $data, new Person() )
$array = HydractorConverte::toObject($obj)

```
# Output with HydractorConverte::toArry


     Extract values from an object
     converting the object to an associative array
     @param  object $object
     @return array
   
    public static function toArray($object): array


```php

$obj = HydractorConverte::toArry( $data, new Person() )
var_dump($obj)

(
    [id:Person:private] => 1
    [firstname:Person:private] => Joe
    [lastname:Person:private] => Doe
    [username:Person:private] => carmen
    [email:Person:private] => email@example.com
    [password:Person:private] =>1234 
}

```
# Output with $array = HydractorConverte::toObject(object)
   

     Convert an array to object 
     @param  array $array
     @return objects

    public static function toObject(array $array, $object)

```php

$array = HydractorConverte::toObject($obj)

Array
(
    [firstname] => Joe
    [lastname] => Doe
    [username] => carmen
    [email] => email@example.com
    [password] => $2y$10$vJNLgGV2tK26VcT.Ufbe2OfhJhTbd9Ka2XN1ibx6NtyNf7eFuToWu
)
```

```php

    echo $array->getPassword();
print 

	   $2y$10$vJNLgGV2tK26VcT.Ufbe2OfhJhTbd9Ka2XN1ibx6NtyNf7eFuToWu
```
## Logger

```php

$file = new \Ballybran\Helpers\Log\FileLoggerFactory("text.txt", "outra/");
$b = $file->createLogger();
echo $b->write(["Hello World", 'other'=>"teste"], "F");


$loggerFactory = new \Ballybran\Helpers\Log\StdoutLoggerFactory();
$logger = $loggerFactory->createLogger();
echo $logger->write("Hello World");
 ```
## License

[MIT license](LICENSE.md)


