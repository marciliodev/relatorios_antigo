<?php

/**
 * Created by PhpStorm.
 * User: marci
 * Date: 04/04/2018
 * Time: 10:41
 */

require_once "assents/conexao/conexao.php";
require_once "MPDF/mpdf.php";

class reportCliente extends mpdf{

    // Atributos da classe
    private $pdo  = null;
    private $pdf  = null;
    private $css  = null;
    private $titulo = null;

    /*
    * Construtor da classe
    * @param $css  - Arquivo CSS
    * @param $titulo - Título do relatório
    */
    public function __construct($css, $titulo) {
        $this->pdo  = Conexao::getInstance();
        $this->titulo = $titulo;
        $this->setarCSS($css);
    }

    /*
    * Método para setar o conteúdo do arquivo CSS para o atributo css
    * @param $file - Caminho para arquivo CSS
    */
    public function setarCSS($file){
        if (file_exists($file)):
            $this->css = file_get_contents($file);
        else:
            echo 'Arquivo CSS inexistente!';
        endif;
    }

    /*
    * Método para montar o Cabeçalho do relatório em PDF
    */
    protected function getHeader(){
        $data = date('j/m/Y');
        $retorno = "<table class=\"tbl_header\" width=\"1000\">  
               <tr>  
                 <td align=\"left\">Biblioteca mPDF</td>  
                 <td align=\"right\">Gerado em: $data</td>  
               </tr>  
             </table>";
        return $retorno;
    }

    /*
    * Método para montar o Rodapé do relatório em PDF
    */
    protected function getFooter(){
        $retorno = "<table class=\"tbl_footer\" width=\"1000\">  
               <tr>  
                 <td align=\"left\"><a href=''>#</a></td>  
                 <td align=\"right\">Página: {PAGENO}</td>  
               </tr>  
             </table>";
        return $retorno;
    }

    /*
    * Método para construir a tabela em HTML com todos os dados
    * Esse método também gera o conteúdo para o arquivo PDF
    */
    private function getTabela(){
        $color  = false;
        $conteudo_html = "";

        $conteudo_html .= "<h2 style=\"text-align:center\">{$this->titulo}</h2>";
        $conteudo_html .= '<img src=\"assents/logomarcas/nova_logo_marca_1.jpg\" align=\"center\" width=\"150\" height=\"100\">';
        $conteudo_html .= "<table border='1' width='1000' align='center'>
           <tr class='header'>  
             <th>Discriminação Detalhada do Produto</td>  
             <th>Estoque do Almoxarifado</td>  
             <th>Estoque Total</td>  
             <th>Valor Unitário</td>  
             <th>Valor Total</td>  
           </tr>";

        $sql = "select * from produtos";
        foreach ($this->pdo->query($sql) as $reg):
            $conteudo_html .= ($color) ? "<tr>" : "<tr class=\"zebra\">";
            $conteudo_html .= "<td class='destaque'>{$reg['disc_produto']}</td>";
            $conteudo_html .= "<td>{$reg['qt_total']}</td>"; //quantidade total do estoque
            $conteudo_html .= "<td>{$reg['qt_atual']}</td>"; //quantidade atual do estoque
            $conteudo_html .= "<td>{$reg['vl_unitario']}</td>"; //valor unitário do produto
            $conteudo_html .= "<td>{$reg['vl_total']}</td>"; //valor total do produto
            $color = !$color;
        endforeach;

        $conteudo_html .= "</table>";
        return $conteudo_html;
    }

    /*
    * Método para construir o arquivo PDF de Material de Escritório
    */
    public function GerarPDF_M_E(){
        set_time_limit(300); //seta o tempo limite de resposta para gerar o pdf
        ini_set("memory_limit", "600M"); //seta a quantidade de memória usada pelo servidor
        $this->pdf = new mPDF('utf-8', 'A4');
        //Trata caracteres especiais sem gerar erro
        $this->pdf->allow_charset_conversion=true;
        $this->pdf->charset_in='iso-8859-1';
        $this->pdf->charset_in='windows-1252';
        //Corpo do pdf
        $this->pdf->WriteHTML($this->css, 1);
        $this->pdf->SetHTMLHeader($this->getHeader());
        $this->pdf->SetHTMLFooter($this->getFooter());
        $this->pdf->WriteHTML($this->getTabela());
        $this->pdf->SetDisplayMode('fullpage');
        $this->pdf = new mPDF(['tempDir' => __DIR__ . '/tmp']);
        ob_clean(); //limpa o objeto dos dados do pdf
    }

    /*
    * Método para construir o arquivo PDF de Material de Serviço Vascular
    */
    public function GerarPDF_M_V_S(){
        set_time_limit(300); //seta o tempo limite de resposta para gerar o pdf
        ini_set("memory_limit", "600M"); //seta a quantidade de memória usada pelo servidor
        $this->pdf = new mPDF('utf-8', 'A4');
        //Trata caracteres especiais sem gerar erro
        $this->pdf->allow_charset_conversion=true;
        $this->pdf->charset_in='iso-8859-1';
        $this->pdf->charset_in='windows-1252';
        //Corpo do pdf
        $this->pdf->WriteHTML($this->css, 1);
        $this->pdf->SetHTMLHeader($this->getHeader());
        $this->pdf->SetHTMLFooter($this->getFooter());
        $this->pdf->WriteHTML($this->getTabela());
        $this->pdf->SetDisplayMode('fullpage');
        $this->pdf = new mPDF(['tempDir' => __DIR__ . '/tmp']);
        ob_clean(); //limpa o objeto dos dados do pdf
    }

    /*
    * Método para exibir o arquivo PDF
    * @param $name - Nome do arquivo se necessário grava-lo
    */
    public function Exibir($name = null) {
        $this->pdf->Output($name, 'I');
    }
}