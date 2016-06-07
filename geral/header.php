<?php 
if (!defined("ROOT"))
	exit();

$tela = $this->getDados('tela');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo THEME_URL?>css/style.css" type="text/css">
</head>
<body>
<?php if (!empty($_COOKIE['sessionUserID']) && $tela != 'telaLogin') : ?>
<div id="boxLogout">
	<a href="?controller=default&action=logout">Logout</a>
</div>
<?php endif; ?>