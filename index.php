<?php
/**
 * Created by PhpStorm.
 * User: marci
 * Date: 04/04/2018
 * Time: 10:55
 */
// Require no script da classe reportCliente
require_once "reportCliente.php";

/*
  * Verifica se é uma submissão, se for instância o objeto reportCliente
  * passa os parâmetros para o construtor, chama o método para construção do PDF
  * e manda exibi-lo no navegador.
  */
//if(isset($_GET['submit'])):
    $report = new reportCliente("css/estilo.css", "Relatório de Material de Escritório");
    $report->GeraPDF(); // chama a construção do pdf.
    $report->Exibir("Material de Escritório"); //nome do arquivo relatório que será salvo.
//endif;
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Testando relatório com mPDF</title>
</head>
<!--
<body>
<form action="" method="GET" target="_blank">
    <input type="submit" value="Gerar relatório" name="submit"/>
</form>
-->
</body>
</html>