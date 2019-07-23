<html>
  <head>
      <style>
        @media print {
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 3px 5px; }
        td { font-family: arial; font-size: 9px; padding: 15px 15px; color: #000; text-align:center;}
        table { padding: 50px 50px;}
        }
        
          
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 3px 5px;}
        td { font-family: arial; font-size: 9px; padding: 2px 10px; color: #000; text-align:center;}
        table { padding: 10px 10px; width: 100%;}
      </style>
    
    
  </head>
  <body>
      <br/><br/><br/><br/><br/>
      
  <td>
      <table>
          <tr>
              <td ><img src="{{$img->archivo}}" alt="Sin foto" width="100px"></img> </td>
          </tr>
          <tr>
              <td >{{$inscripcion->matricula}}</td>
          </tr>
          <tr>
              <td >{{$cliente->nombre}} {{$cliente->nombre2}} {{$cliente->ape_paterno}} {{$cliente->ape_materno}}</td>
          </tr>
      </table>
  </td>
  </body>
</html>
