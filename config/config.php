<?php
// Variáveis Root
define("ROOT", "{$_SERVER['DOCUMENT_ROOT']}/testePraticoEAD/desafioEAD/");
define("THEME_ROOT", ROOT."/geral/");

define("URL", "http://localhost/testePraticoEAD/desafioEAD/");
define("THEME_URL", URL."geral/");

// Variáveis Banco de Dados
define("DBTYPE", "mysql");
define("HOST", "localhost");
define("DBNAME", "desafio_ead");
define("USER", "root");
define("PASS", "123456");

require_once("functions.php");
?>