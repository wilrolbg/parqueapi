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
    <title>Entrada y Salida</title>
</head>
<body>
<table class="table" align="center">
  <thead>
    <tr>
      <th colspan="7" class="fondo">Resumen de Movimientos de Entrada y Salida</th>
    </tr>
    <tr class="fondo">
      <th>Nro. Factura</th>
      <td>Fecha</td>
      <td>Fecha Entrada</td>
      <td>Fecha Salida</td>
      <td>Hora Entrada</td>
      <td>Hora Salida</td>
      <td>Monto</td>      
    </tr>    
  </thead>
  <tbody>
  @foreach ($facturas as $item)
    <tr class="cuerpo">
      <th>{{$item->numero}}</th>
      <td class="centro">{{date('d-m-Y', strtotime($item->fecha))}}</td>
      <td class="centro">{{date('d-m-Y', strtotime($item->fecha_entrada))}}</td>
      <td class="centro">{{date('d-m-Y', strtotime($item->fecha_salida))}}</td>
      <td class="centro">{{$item->hora_entrada}}</td>
      <td class="centro">{{$item->hora_salida}}</td>
      <td class="montos">{{$nombre_format_francais = number_format($item->monto_factura, 2, ',', ' ')}}</td>      
    </tr>
    @endforeach    
  </tbody>
</table>
</body>
</html>