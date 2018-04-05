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
if(isset($_GET['submit'])):
    if ($GET = "Material de Escritório") {
        $report = new reportCliente("assents/css/estilo.css", "Relatório de Material de Escritório");
        $report->GerarPDF_M_E(); // chama a construção do pdf.
        $report->Exibir("Relatório de Material de Escritório"); //nome do arquivo relatório que será salvo.
    }
    if ($GET = "Material de Serviço Vascular"){
        $report = new reportCliente("assents/css/estilo.css", "Relatório de Material de Serviço Vascular");
        $report->GerarPDF_M_S_V(); // chama a construção do pdf.
        $report->Exibir("Relatório de Material de Serviço Vascular"); //nome do arquivo relatório que será salvo.
    }
endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Relatórios Almoxarifado</title>
</head>
<body>
<form action="" method="GET" target="_blank">
    <input type="submit" value="Material de Escritório" name="submit"/>
    <input type="submit" value="Material de Serviço Vascular" name="submit"/>
</form>
</body>
</html>