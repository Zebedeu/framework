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

Create a new Dot object:

```php
$dot = new \Adbar\Dot;

// With existing array
$dot = new \Adbar\Dot($array);
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

## License

[MIT license](LICENSE.md)


