<?php 


//CARREGAR DOMPDF
@include "dompdf2/autoload.inc.php";
@include "config.php";

use Dompdf\Dompdf;
use App\Models\Movimentacao;


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));

$total_entradas = 0;
$total_saidas = 0;
$saldo = 0;

$data = date('Y-m-d');

$tabela = Movimentacao::where('data', '>=', $dataInicial)->where('data', '<=', $dataFinal)->get();

foreach($tabela as $tab){

  if ($tab->tipo == 'Entrada') {
    @$total_entradas = $total_entradas + $tab->value;
  } else {
    @$total_saidas = $total_saidas + $tab->value;
  }
}

$saldo = $total_entradas - $total_saidas;

$total_entradas = number_format($total_entradas, 2, ',', '.');          
$total_saidas = number_format($total_saidas, 2, ',', '.');          
$saldo = number_format($saldo, 2, ',', '.'); 

$dataInicial = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinal = implode('/', array_reverse(explode('-', $dataFinal)));

//ALIMENTAR OS DADOS NO RELATÓRIO
$body1 = "

<style>
    @page {
        margin: 0px;
        
    }

    .footer {
        position:absolute;
        bottom:0;
        width:100%;
        background-color: #ebebeb;
        padding:10px;
    }

    .cabecalho {    
        background-color: #ebebeb;
        padding:10px;
        margin-bottom:30px;
    }

    .titulo{
        margin:0;
        font-size:23px;
        font-family:Arial, Helvetica, sans-serif;
        
    }

    .subtitulo{
        margin:0;
        font-size:14px;
        font-family:Arial, Helvetica, sans-serif;
    }

    .texto_data{
        margin:0;
        font-size:8px;
        font-family:Arial, Helvetica, sans-serif;
    }

    .datas{
        margin-left:15px;
        font-size:11px;
        font-family:Arial, Helvetica, sans-serif;
        margin-top:5px;
    }

    .titulos{
        margin:10px;
    }

    .table{
        padding:20px;
        font-family:Verdana, sans-serif;
        margin-top:20px;
    }

    .texto-tabela{
        font-size:11px;
    }

    .areaTotais{
        border : 0.5px solid #bcbcbc;
        padding: 15px;
        margin-right:15px;
        margin-left:15px;
    }

</style>

<div class='cabecalho'>
    <div class='titulos'>
        <div align='right' class='texto_data'> $data_hoje</div>	
        <h3 class='titulo'><b>$nome_estabelecimento</h3>
        <span class='subtitulo'>$endereco</span>
        
    </div>
</div>

<div class='container'>
    <h3 align='center' class='titulo'>Relatório de Movimentações</h3>
    <div align='center' class='datas'>
        De $dataInicial à $dataFinal
    </div>
   
    <table  class='table' width='100%' border='1' cellspacing='0' cellpadding='3'>
        <tr bgcolor='#f9f9f9'>
            <td style='font-size:12px'> <b>Descrição</b> </td>
            <td style='font-size:12px'> <b> Recepcionista</b> </td>
            <td style='font-size:12px'> <b> Data</b> </td>
            <td style='font-size:12px'> <b>Tipo</b> </td>
            <td style='font-size:12px'> <b> Valor</b> </td>
        </tr>";
        ?>
        <?php
            $bodydois = ""; 
            foreach($itens as $item){
                $valor = number_format($item->value, 2, ',', '.');
                $data = implode('/', array_reverse(explode('-', $item->data)));
                $body2 = "
                    <tr>
                        <td>$item->descricao</td>
                        <td>$item->recep</td>
                        <td>$data</td>
                        <td>$item->tipo</td>
                        <td>$valor</td>
                    </tr>
                ";
                $bodydois = $bodydois . $body2;
            }
        ?>
        <?php $body3 = "
    </table>
    
</div>
<div class='areaTotais'>
    <b>Total Entradas :</b> <span>R$ $total_entradas</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
    <b>Total Saídas :</b> <span>R$ $total_saidas</span>      
    <div align='right'><b>Saldo Total :</b> <span >R$ $saldo</span></div>       
</div>
";

$conteudo = $body1 .  $bodydois . $body3;
$html = utf8_encode($conteudo);

//INICIALIZAR A CLASSE DO DOMPDF
$pdf = new DOMPDF();

//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrail');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html(utf8_decode($html));

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'relatorio.pdf',
array("Attachment" => false)
);
?>