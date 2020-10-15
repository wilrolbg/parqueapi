<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .centro{
            text-align: center;
            }        
    </style>
    <title>Ticket Salida</title>
</head>
<body>
    <table>
    <tr>
        <td class="centro"><h3>PARQUEADERO</h3></td>
    </tr>
    <tr>
        <td>Fecha de Emisión: {{ $fecha_factura }}</td>
    </tr>    
    <tr>
        <td>=================================================</td>
    </tr>
    <tr>
        <td class="centro"><h5>TICKET DE SALIDA</h5></td>
    </tr>
    <tr>
        <td><h5>Nro. Factura: {{ $numero_factura }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente: {{ $nombres }} {{ $apellidos }}</h5></td>
    </tr>    
    <tr>
        <td class="centro"><h2>Salida: {{ $hora_salida }}</h2></td>
    </tr>
      <tr>
        <td class="centro"><h3>Entrada:{{ $hora_entrada }}</h3></td>
    </tr>
    <tr>
        <td class="centro"><h2>{{ $placa }}</h2></td>
    </tr>    
    <tr>
        <td class="centro">Fecha Entrada: {{ $fecha_entrada }}</td>
    </tr> 
    <tr>
        <td class="centro">Fecha Salida: {{ $fecha_salida}}</td>
    </tr>     
    <tr>
        <td class="centro"><h5>Sitio de Parqueo: {{ $puesto }}</h5></td>
    </tr> 
    <tr>
        <td class="centro"><h3>***MONTO A PAGAR***<h3></td>
    </tr>
    <tr>
        <td class="centro"><h3>$ {{ $monto_factura }}</h3></td>
    </tr>      
    <tr>
        <td>=================================================</td>
    </tr>                 
    </table>
</body>
</html>