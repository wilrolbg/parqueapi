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
    <title>Ticket Entrada</title>
</head>
<body>
    <table>
    <tr>
        <td class="centro"><h3>PARQUEADERO</h3></td>
    </tr>
    <tr>
        <td>=================================================</td>
    </tr>
    <tr>
        <td><h5>Cliente: {{ $nombres }} {{ $apellidos }}</h5></td>
    </tr>     
    <tr>
        <td class="centro"><h5>TICKET DE INGRESO</h5></td>
    </tr>
      <tr>
        <td class="centro"><h2>{{ $hora_entrada }}</h2></td>
    </tr>
    <tr>
        <td class="centro"><h2>{{ $placa }}</h2></td>
    </tr>    
    <tr>
        <td class="centro">{{ $fecha_entrada }}</td>
    </tr> 
    <tr>
        <td class="centro"><h5>Sitio de Parqueo: {{ $puesto }}</h5></td>
    </tr> 
    <tr>
        <td>=================================================</td>
    </tr>              
    </table>
</body>
</html>