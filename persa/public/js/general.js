$(document).ready(function() {
    $('#table_data').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "language": {
            "paginate": {
                "previous": "Anterior",
                "next": "Sgte"
            },
            "search": "Buscar:",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No existen registros",
        }
    });
});

function remove(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Envía el formulario de eliminación
            document.getElementById(`form-delete-${id}`).submit();
            
            // Mostrar mensaje de éxito 
            Swal.fire(
                'Eliminado',
                'El permiso ha sido eliminado.',
                'success'
            );
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