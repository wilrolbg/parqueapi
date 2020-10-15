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
    <title>Iteraciones</title>
</head>
<body>
<table class="table" align="center">
  <thead>
    <tr>
      <th colspan="2" class="fondo">PUESTOS MAS UTILIZADOS</th>
    </tr>
    <tr class="fondo">
      <td>Puesto</td>
      <td>Veces Utilizado</td>      
    </tr>    
  </thead>
  <tbody>
  @foreach ($puestos as $item)
    <tr class="cuerpo">
      <td class="centro">{{ $item->puesto }}</td>
      <td class="montos">{{ $item->veces }}</td>      
    </tr>
    @endforeach    
  </tbody>
</table>
</body>
</html>