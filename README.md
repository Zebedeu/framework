[![Build Status](https://travis-ci.org/knut7/framework.svg?branch=1.0.2)](https://travis-ci.org/knut7/framework)
[![license](https://img.shields.io/github/license/Knut7/Knut7.svg)]()
[![Packagist](https://img.shields.io/packagist/v/Knut7/Knut7.svg)]()

/**
 *
 * knut7 Framework (http://framework.artphoweb.com/)
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2016.  MACHIZE Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
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
Link pra contribuições e Download : https://github.com/knut7/knut7




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


A knut7- FRAMEWORK segue o padrão arquitetural Modelo Visão e Controller(MVC)



## License

Firewall is licensed under the [MIT license](LICENSE).
