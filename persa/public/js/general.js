function initDataTable() {
    // Verifica si ya está inicializada y la destruye (sin borrar datos)
    if ($.fn.DataTable.isDataTable('#table_data')) {
        $('#table_data').DataTable().destroy();
    }

    // Ahora sí vuelve a crearla
    $('#table_data').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "language": {
            "paginate": {
                "previous": "Anterior",
                "next": "Sgte"
            },
            "search": "Buscar:",
            "info": "Mostrando START a END de TOTAL registros",
            "infoEmpty": "No existen registros",
        }
    });
}

function remove(event ,id) {
    event.preventDefault(); //previene el envio inmediaro del formulario
    const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "¿Estas seguro?",
  text: "¡esta acción no se puede revertir!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Eliminar",
  cancelButtonText: "cancelar",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swalWithBootstrapButtons.fire({
      title: "Eliminar",
      text: "Registro eliminado exitosamente",
      icon: "success"
    });
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire({
      text: "Acción cancelada",
      icon: "error"
    });
  }
});
}

function update() {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Actualizado correctamente',
        showConfirmButton: false,
        timer: 1500
    });
}

function create() {
    Swal.fire({
        title: 'Creado exitosamente',
        text: 'El registro se ha creado con exitosamente',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
}