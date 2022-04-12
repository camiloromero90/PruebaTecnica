<script src="https://use.fontawesome.com/af27afbee8.js"></script>
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">

    <div class="container">
    <div class="row mt-5">
      <div class="col-12">
        <h3>Lista de empleados</h3>
      </div>

      <div class="col-12  d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ url('/empleados/nuevoEmpleado') }}">Crear</a>
      </div>

      <div class="col-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Email</th>
              <th scope="col">Sexo</th>
              <th scope="col">Area</th>
              <th scope="col">Boletin</th>
              <th scope="col">Modificar</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
      @foreach($data as $dat)
      @php
      if($dat->sexo == "M"){
          $sexo="Masculino";
      } else{
        $sexo="Femenino";
      }


      if($dat->boletin == 1){
          $boletin="Si";
      } else{
        $boletin="No";
      }


      @endphp
    <tr>
      <th scope="row">{{$dat->empleado}}</th>
      <td>{{$dat->email}}</td>
      <td>{{$sexo}}</td>
      <td>{{$dat->nombre}}</td>
      <td>{{$boletin}}</td>
      <td><a href="{{ url('/empleados/editEmpleado', ['idEmpleado' => $dat->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
      <td><a id="idEmpleado"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
    </tr>
    <input type="hidden" id="id" name="id" value="{{$dat->id}}" >
    @endforeach
  </tbody>
        </table>
      </div>

    </div>



</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
<script>


$('#idEmpleado').on('click', function(e){



var id = $('#id').val();
$.ajax({
            async:true,
            type: 'POST',
            url: '/empleados/deleteEmpleado',
            dataType: 'json',
            data: {_token: "{{ csrf_token() }}",id:id},
            statusCode: {
                200: function(data) {
                    swal.fire({
                            title: "Bien hecho",
                            text: "El empleado ha sido eliminado con éxito",
                            type: "success"                        
                        });
                        location.reload();
                },
                401: function (data) {
                    swal.fire({
                            title: "Error",
                            text: "Complete los campos obligatorios",
                            type: "error"
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });
</script>