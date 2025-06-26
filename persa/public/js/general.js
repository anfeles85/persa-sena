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

function remove() {
    var x = confirm("¿Está seguro de que desea eliminar el registro?");
    if (x)
        return true;
    else
        return false;
}


// Función para mostrar alerta de éxito si existe un mensaje en sessionStorage
function showSuccessAlert() {
    const successMessage = sessionStorage.getItem('success');
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: '¡OK!',
            text: successMessage,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        // Limpiar el mensaje después de mostrarlo
        sessionStorage.removeItem('success');
    }
}

// Función para confirmar eliminación
function confirmRemove(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete-' + id).submit();
        }
    });
}

// Llamar a la función cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    showSuccessAlert();
});