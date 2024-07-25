document.getElementById('logout-button').addEventListener('click', function(event) {
    event.preventDefault(); 
    Swal.fire({
        title: '¿Quiere cerrar la sesión?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?pages=logout';
              Swal.fire(
                  '¡Sesión cerrada!',
                  'Tu sesión ha sido cerrada correctamente.',
                  'success'
             );
        }
    });
});