
# Typographer

<p align="center"> 
 <a href="https://www.artlebedev.ru/typograf/"><img src="https://img.artlebedev.ru/typograf/before-after.gif" alt="Typographer" height="200"></a>
</p>

<p align="center">
<a href="https://packagist.org/packages/impeck/artlebedev-typograf"><img alt="Packagist" src="https://img.shields.io/packagist/dt/impeck/artlebedev-typograf.svg"></a>
</p>

There comes a time in the life of every decent webmaster when he seriously thinks about screen typography.

On the one hand, he wants the typed text to look good in the browser window. And to do this, instead of signs of the inch to put a normal quote ("herringbone" and "feet"), to kill the extra space, in the right places to change the hyphens into hyphens, unbroken space "tied" all the short conjunctions and prepositions to follow them to words and make a bunch of other operations. On the other hand, do not really want to put all these icons, quotation marks and non-breaking spaces by hand.

Lebedev Studio was the first on the Internet to declare the importance of using on-screen typography in the layout of materials. Since 2000, the texts of all websites created by Lebedev Studio are put in order with the help of "Typographer". Since 2002 the program has been available on our site for free.

You can read more about the principles of screen typography in [§ 62](https://www.artlebedev.ru/kovodstvo/sections/62/) "Guidelines".

Do you want something special from Typographer? [Email us](mailto:tema@tema.ru?subject=typograf_wish_list).

Typograf homepage: http://typograf.artlebedev.ru/

Web-service address: http://typograf.artlebedev.ru/webservices/typograf.asmx

WSDL-description: http://typograf.artlebedev.ru/webservices/typograf.asmx?WSDL

## Installation

Installation by using

```sh
   composer require impeck/artlebedev-typograf
```

## Usage and customization

A sample use case is given in [example.php](https://github.com/Impeck/artlebedev-typograf/blob/main/example.php)

```php
   <?php

   require 'vendor/autoload.php';

   use ArtLebedevStudio\RemoteTypograf;

   $remoteTypograf = new RemoteTypograf();
```

### Output characters

#### Ready characters — «а»

Default. The characters are output as the reader sees them as a result.

```php
   $remoteTypograf->noEntities();
```

#### Alphabetic codes — `&laquo;a&raquo;`

Good for XML, bad for old browsers.

```php
   $remoteTypograf->htmlEntities();
```

#### Numeric codes — `&171;a&187;`

Somebody needs. Bad for older browsers.

```php
   $remoteTypograf->xmlEntities();
```

#### Alphabetic and numeric codes — `&laquo;a&raquo;` and `171;a&187;`

```php
   $remoteTypograf->mixedEntities();
```

### Put line breaks

Default `false`

```php
   $remoteTypograf->br(true);
```

### Paragraph marking

Default `false`

```php
   $remoteTypograf->p(true);
```

### Number of tags `</br>` in a row

```php
   $remoteTypograf->nobr(3);
```

### First level quotation marks

Default « » — French

```php
   $remoteTypograf->quotA('laquo raquo');
```

### Second level quotation marks

Default „ “ — German

```php
   $remoteTypograf->quotB('bdquo ldquo'); 
```

#### Possible quote options

`laquo raquo` — French « »

`bdquo ldquo` — German „ “

`quot quot` — Programmers " "

`lsquo rsquo` — English singles  ‘ ’

`ldquo rdquo` — English double “ ”

`sbquo lsquo` — ' '

## The authors of "Typograph"

### Artemy Lebedev

all his life dreamed of using long dashes on the web. After several years of dreaming, he wrote [§ 62](https://www.artlebedev.ru/kovodstvo/sections/62/) and made everyone do the extra work. Together with Alexander Petrosyan, he wrote an AppleScript version of Typograph.

### Alexey Smychagin

wrote his own program; he collected all the wishes and added the "Typograph" to the web

### Denis Avrahamov

was the first guy in the studio who was too lazy to do all the typography by hand and wrote an automatic script

### Konstantin Zhilin

helped Avrahamov

### Konstantin Tomashevich

wrote his own program that put the typography into the theatrical web administration system

### Andrei Shitov

wrote [XML web-service](https://www.artlebedev.ru/typograf/webservice/) and examples of its use in several languages

### Vladimir Tokmakov

collected a lot of suggestions and rewrote "Typograph" from scratch

### Sergei Moskalev

sent a collection of text processing rules after scanning
