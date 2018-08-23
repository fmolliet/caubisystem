
<div class="interface">
<?php
//include dirname(dirname(dirname(__FILE__)))."/rest/control/Control.php";
$control = new control();
$result = $control->siteClient_show_all();
echo "<h3>Todos clientes</h3>";
echo "<table id='tabela' border='1' style='display:block;'>
<tr>
<th>ID do Cliente</th>
<th>APP KEY</th>
<th>CPF/CNPJ</th>
<th>Primeiro nome</th>
<th>Segundo Nome</th>
<th>Email</th>
<th>Nome do Negócio</th>
<th>Endereço</th>

</tr>";
//<th>Cidade/estado</th>
foreach($result as $row)
{
    echo "<tr>";
    echo "<td>" . $row->client_id. "</td>";
    echo "<td>" . $row->appkey . "</td>";
    echo "<td>" . $row->cpf . "</td>";
    echo "<td>" . $row->first_name . "</td>";
    echo "<td>" . $row->last_name . "</td>";
    echo "<td>" . $row->email . "</td>";
    echo "<td>" . $row->business . "</td>";
    echo "<td>" . $row->address . "</td>";
    //echo "<td>" . $row->city ." - ".$row->state . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</div>