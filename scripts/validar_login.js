const usuario = document.getElementById('username');
const pass = document.getElementById('password');
const form = document.getElementById('form_login');
form.addEventListener('submit',e=>{
    if(usuario.value.length == 0){
        alert("El campo usuario está vacío");
        e.preventDefault();
    }
    if(pass.value.length == 0){
        alert("El campo contraseña está vacío");
        e.preventDefault();
    }
}
    
);