const expresiones = {
    usuario: /^[a-zA-Z0-9]{3,20}$/,
    pass: /^[a-zA-Z0-9]{8,20}$/
}

const usuario = document.getElementById('username');
const pass = document.getElementById('password');
const form = document.getElementById('form_login');
const msguser = document.getElementById('mensaje_user');
const msgpass = document.getElementById('msg_pass');

usuario.addEventListener('blur', (e)=>{
    if(expresiones.usuario.test(usuario.value)){
        document.getElementById('username').style.color = "#FFF";
        msguser.style.display = 'none';
    }
    else{
        document.getElementById('username').style.color = "red";
        msguser.style.display = 'block';
        e.preventDefault();

    }
});


usuario.addEventListener('keyup', (e) =>{
    if(expresiones.usuario.test(usuario.value)){
        document.getElementById('username').style.color = "#FFF";
        msguser.style.display = 'none';
    }
    else{
        document.getElementById('username').style.color = "red";
        e.preventDefault();

    }
});

pass.addEventListener('blur', (e) =>{
    if(expresiones.pass.test(pass.value)){
        document.getElementById('password').style.color = "#FFF";
        msgpass.style.display = 'none';
    }
    else{
        document.getElementById('password').style.color = "red";
        msgpass.style.display = 'block';
        e.preventDefault();
    }
});

pass.addEventListener('keyup', (e)=>{

    if(expresiones.pass.test(pass.value)){
        document.getElementById('password').style.color = "#FFF";
        msgpass.style.display = 'none';
    }
    else{
        document.getElementById('password').style.color = "red";
        e.preventDefault();

    }
});

form.addEventListener('submit',e=>{
    if(usuario.value.length == 0){
        msguser.style.display = "block"        
        e.preventDefault();
    }

    if(pass.value.length == 0){
        msgpass.style.display = 'block';
        e.preventDefault();
    }
      
}
    
);
function convertirAMinusculas(elemento) {
    elemento.value = elemento.value.toLowerCase();
}

const pass_funct = document.getElementById('password'),
      icon =document.querySelector('.bx');

icon.addEventListener("click", e=>{

    if(pass_funct.type === "password"){
        pass_funct.type="text";
        icon.classList.remove('bx-show-alt');
        icon.classList.add('bx-hide');

    }else{
        pass_funct.type ="password";
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show-alt');
    }

}
);