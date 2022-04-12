<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    
<div class="container">

<form id="formBudget" method="post">
@csrf
    <div class="alert alert-info" role="alert">
       Los campos con asteriscos (*) son obligatorios
    </div>

    <div class="row mb-3">
        <div class="col-3">
          <label for="name" class="col-form-label d-flex justify-content-end">Nombre completo *</label>
        </div>
        <div class="col-9">
          <input type="text" id="name" name="name" class="form-control" placeholder="Nombre completo del empleado" required>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-3">
          <label for="email" class="col-form-label d-flex justify-content-end">Correo electronico *</label>
        </div>
        <div class="col-9">
          <input type="text" id="email" name="email" class="form-control" placeholder="Correo electronico" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
          <label for="email" class="col-form-label d-flex justify-content-end">Sexo *</label>
        </div>
        <div class="col-9">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" value="M" required>
                <label class="form-check-label" for="male">
                  Masculino
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" value="F" checked required>
                <label class="form-check-label" for="female">
                  Femenino
                </label>
              </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
          <label for="area" class="col-form-label d-flex justify-content-end">Area *</label>
        </div>
        <div class="col-9">
          <select name="area" id="area" class="form-control" required>
              <option value="" selected>Seleccione area</option>
              @foreach($data as $areas)
              <option value="{{$areas->id}}" >{{$areas->nombre}}</option>
              @endforeach
          </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
          <label for="description" class="col-form-label d-flex justify-content-end">Descripcion *</label>
        </div>
        <div class="col-9">
          <textarea id="description" name="description" required class="form-control" placeholder="Descripcion de la experiencia del empleado"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
          <label for="description" class="col-form-label"></label>
        </div>
        <div class="col-9">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="si" id="boletin" name="boletin">
                <label class="form-check-label" for="boletin">
                  Deseo recibir boletin informativo
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-3">
          <label for="description" class="col-form-label d-flex justify-content-end">Roles *</label>
        </div>
        <div class="col-9">
        @foreach($roles as $roles)
            <div class="form-check">
                <input class="form-check-input" name="roles" type="checkbox" value="{{$roles->id}}" id="profesional" >
                <label class="form-check-label" for="profesional">
                  {{$roles->nombre}}
                </label>
            </div>
            @endforeach
            <div class="form-check">
            <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>

</form>
</div>

</body>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
<script>


$('#formBudget').on('submit', function(e){

        e.preventDefault();
        $.ajax({
            async:true,
            type: 'POST',
            url: '/empleados/crearEmpleado',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                200: function(data) {
                    swal.fire({
                            title: "Bien hecho",
                            text: "El empleado ha sido creado con éxito",
                            type: "success"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                location.href="empleados/crearEmpleado" + data.patient_id
                            }
                        });
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

    $(document).on('ready', function() {
    $('input[type=checkbox]').live('click', function(){
        var parent = $(this).parent().attr('id');
        $('#'+parent+' input[type=checkbox]').removeAttr('checked');
        $(this).attr('checked', 'checked');
    });
});

</script>
</html>