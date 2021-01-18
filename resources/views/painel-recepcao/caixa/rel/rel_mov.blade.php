<?php 


//CARREGAR DOMPDF
@include "dompdf2/autoload.inc.php";
use Dompdf\Dompdf;


//ALIMENTAR OS DADOS NO RELATÓRIO
$body1 = "
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' integrity='sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z' crossorigin='anonymous'>
<h3 align='center' class='text-danger'>Relatório de Movimentações</h3>

<table class='table' width='100%'>
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

                    <td>
                    $item->descricao
                    </td>
                    <td>
                    $item->recep
                    </td>
                    <td>
                    $data
                    </td>
                    <td>
                    $item->tipo
                    </td>
                    <td>
                    $valor
                    </td>
                    </tr>
                    ";
                    $bodydois = $bodydois . $body2;
                }
                ?>
            

<?php $body3 = "
         
</table>

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