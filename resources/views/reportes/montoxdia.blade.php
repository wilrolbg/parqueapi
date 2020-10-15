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
    <title>Total por Dia</title>
</head>
<body>
<table class="table" align="center">
  <thead>
    <tr>
      <th colspan="2" class="fondo">TOTALIZACION POR DIA</th>
    </tr>
    <tr class="fondo">
      <td>Fecha</td>
      <td>Monto</td>      
    </tr>    
  </thead>
  <tbody>
  @foreach ($facturas as $item)
    <tr class="cuerpo">
      <td class="centro">{{date('d-m-Y', strtotime($item->fecha))}}</td>
      <td class="montos">{{$nombre_format_francais = number_format($item->total, 2, ',', ' ')}}</td>      
    </tr>
    @endforeach    
  </tbody>
</table>
</body>
</html>