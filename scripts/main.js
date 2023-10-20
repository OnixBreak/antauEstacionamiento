//Es para rastrear boleto perdido
document.addEventListener('DOMContentLoaded', function() {
    var enlaceMostrarOcultar = document.getElementById('mostrar_ocultar_perdido');
    var contenidoOculto = document.getElementById('boleto_perdido');

    enlaceMostrarOcultar.addEventListener('click', function(e) {
        e.preventDefault(); // Evita que el enlace siga el href

        // Cambiar la visibilidad del contenido
        if (contenidoOculto.style.display === 'none') {
            contenidoOculto.style.display = 'block';
        } else {
            contenidoOculto.style.display = 'none';
        }
    });
});
//Este es el de boleto a cobrar
document.addEventListener('DOMContentLoaded', function() {
    var enlaceMostrarOcultar = document.getElementById('mostrar_ocultar_salida');
    var contenidoOculto = document.getElementById('busqueda_boleto');

    enlaceMostrarOcultar.addEventListener('click', function(e) {
        e.preventDefault(); // Evita que el enlace siga el href

        // Cambiar la visibilidad del contenido
        if (contenidoOculto.style.display === 'none') {
            contenidoOculto.style.display = 'block';
        } else {
            contenidoOculto.style.display = 'none';
        }
    });
});