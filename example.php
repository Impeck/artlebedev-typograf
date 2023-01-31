<?php
require 'vendor/autoload.php';

use ArtLebedevStudio\RemoteTypograf;

$remoteTypograf = new RemoteTypograf();

$remoteTypograf->noEntities();
$remoteTypograf->br(false);
$remoteTypograf->p(false);
$remoteTypograf->nobr(3);
$remoteTypograf->quotA('laquo raquo');
$remoteTypograf->quotB('bdquo ldquo');

$text = '"Вы все еще кое-как верстаете в "Ворде"? - Тогда мы идем к вам!"';

print $remoteTypograf->processText($text);
