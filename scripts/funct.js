const expresiones =
{
  placas: /^[a-zA-Z0-9]{4,25}$/,
  modelo: /^[A-Z 0-9]{1,25}$/,
  folio: /^[0-9]{1,100}$/
}



const form_registro = document.getElementById('form_registro');
const placas = document.getElementById('placAuto');
const color_marca = document.getElementById('color_marca');

const form_validar = document.getElementById('form_validar');
const folio_buscar = document.getElementById('folio_a_buscar');
const form_print = document.getElementById('form_print');
const folio_print = document.getElementById('reimpresion');
const cargo = document.getElementById('cargo_index').innerHTML;
if(cargo=="Cargo: Administrador"){
    document.getElementById('grid_reimpresion').style.display = 'block'; 
 
 }

/*Esto convierte las teclas en matusculas*/
function mayus(e) {
    e.value = e.value.toUpperCase();
}

form_registro.addEventListener('keyup',e=>{
    if(expresiones.placas.test(placas.value)){
        document.getElementById('placAuto').style.color = '#FFF';
        document.getElementById('p_plac').style.display = 'none';
              
    }
    else{
        document.getElementById('placAuto').style.color ='red';
    }
    if(expresiones.modelo.test(color_marca.value)){
        document.getElementById('color_marca').style.color = '#FFF';
        document.getElementById('p_color').style.display = 'none';
              
    }
    else{
        document.getElementById('color_marca').style.color ='red';
    }
});


form_registro.addEventListener('submit',e=>{

    if(expresiones.placas.test(placas.value)){
        document.getElementById('placAuto').style.color = '#FFF'; 
    }
    else{
        document.getElementById('p_plac').style.display = 'block';
        e.preventDefault();
    }
    if(expresiones.modelo.test(color_marca.value)){
        document.getElementById('color_marca').style.color = '#FFF'; 
    }
    else{
        document.getElementById('p_color').style.display = 'block';
        e.preventDefault();
    }

});




form_validar.addEventListener('keyup', e=>{
    if(expresiones.folio.test(folio_buscar.value)){
        document.getElementById('folio_a_buscar').style.color = '#FFF';
        document.getElementById('val').style.display = 'none';
    }
    else{
        document.getElementById('folio_a_buscar').style.color = 'red';
        e.preventDefault();
    }
 });


form_validar.addEventListener('submit', e=>{
    if(expresiones.folio.test(folio_buscar.value)){
        document.getElementById('folio_a_buscar').style.color = '#FFF'; 
    }
    else{
        document.getElementById('val').style.display = 'block';
        e.preventDefault();
    }
 });


 form_print.addEventListener('keyup', e=>{
    if(expresiones.folio.test(folio_print.value)){
        document.getElementById('reimpresion').style.color = '#FFF';
        document.getElementById('print').style.display = 'none';
    }
    else{
        document.getElementById('reimpresion').style.color = 'red';
        e.preventDefault();
    }
 });


form_print.addEventListener('submit', e=>{
    if(expresiones.folio.test(folio_print.value)){
        document.getElementById('reimpresion').style.color = '#FFF'; 
    }
    else{
        document.getElementById('print').style.display = 'block';
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


