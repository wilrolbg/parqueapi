<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .centro{
            text-align: center;
            }
        .fondo{
            text-align: center;
            background-color: #716B6A;
            color: #FFFFFF;
        }
        .table {
	        width: 100%;
        }
        .montos {
            text-align: right;
        }
        .cuerpo{
            background-color: #DEE6EC;
        }
    </style>
    <title>Resumen por tipo de Vehiculos</title>
</head>
<body>
<table class="table" align="center">
  <thead>
    <tr>
      <th colspan="3" class="fondo">VEHICULOS POR TIPO</th>
    </tr>
    <tr class="fondo">
      <th>MOTOS</th>
      <td>AUTOMOVILES</td>
      <td>BICICLETAS</td>     
    </tr>    
  </thead>
  <tbody>
    <tr class="cuerpo">
      <td class="centro">{{$tipo_1}}</td>
      <td class="centro">{{$tipo_2}}</td>
      <td class="centro">{{$tipo_3}}</td>    
    </tr> 
  </tbody>
</table>
</body>
</html>