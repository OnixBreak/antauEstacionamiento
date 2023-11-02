const form_registro = document.getElementById('form_registro');
const placas = document.getElementById('placAuto');
const color_marca = document.getElementById('color_marca');

const form_validar = document.getElementById('form_validar');
const folio_buscar = document.getElementById('folio_a_buscar');
/*Esto convierte las teclas en matusculas*/
function mayus(e) {
    e.value = e.value.toUpperCase();
}

form_registro.addEventListener('submit',e=>{
    if(placas.value.length == 0){
        alert("El campo de las placas está vacío");
        e.preventDefault();
    }
    if(color_marca.value.length == 0){
        alert("El campo de descripción está vacío");
        e.preventDefault();
    }
});



 form_validar.addEventListener('submit', e=>{
    if(folio_buscar.value.length == 0){
        alert("El campo de Folio está vacío");
        e.preventDefault();
    }
 });

 const cerrar_sesion = document.getElementById('cerrar_sesion');

 cerrar_sesion.addEventListener('click', e=>{
    var cerrar = window.confirm("Serás redireccionado al reporte del turno");
    if(cerrar == true){
       window.location.href = "reporte_turno.php"; 
    }
    else{
        e.preventDefault();
    }


 });

