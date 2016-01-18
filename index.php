<?php

// Configura algumas constantes...
define('ROOT', __DIR__.'/');
define('SHAREDIR', ROOT.'share/');
define('HTML', ROOT.'views/');

// funções complementares
include ROOT.'lib/Utils.php';

//Checando se é uma solicitação de DOWNLOAD
if(isset($_GET['d'])) download(SHAREDIR.$_GET['d']);

// Carrega a parte HEADER da view HTML
view('header'); 

// Varre o diretório SHARE
$share = shareScan();

// Carrega o "corpo" da view HTML, passando a variável $share
view('body', ['share'=>$share]);

// Carrega a parte FOOTER da view HTML
view('footer');
