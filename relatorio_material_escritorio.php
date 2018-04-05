<?php
/**
 * Created by PhpStorm.
 * User: marci
 * Date: 05/04/2018
 * Time: 10:05
 */

require_once "reportCliente.php";

/*
  * Verifica se é uma submissão, se for instância o objeto reportCliente
  * passa os parâmetros para o construtor, chama o método para construção do PDF
  * e manda exibi-lo no navegador.
  */
//if(isset($_GET['submit'])):
    $report = new reportCliente("assents/css/estilo.css", "Relatório de Material de Escritório");
    $report->GeraPDF(); // chama a construção do pdf.
    $report->Exibir("Material de Escritório"); //nome do arquivo relatório que será salvo.
//endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Rel. Material de Escritório</title>
</head>
<body>
<!--
<form action="" method="GET" target="_blank">
    <input type="submit" value="Material de Escritório" name="submit"/>
    <input type="submit" value="Material de Serviço Vascular" name="submit"/>
</form>
-->
</body>
</html>