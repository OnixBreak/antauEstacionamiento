const usuario = document.getElementById('username');
const pass = document.getElementById('password');
const form = document.getElementById('form_login');
const msguser = document.getElementById('mensaje_user');
const msgpass = document.getElementById('msg_pass');

usuario.addEventListener('blur',function(e){
    if(usuario.value.length == 0){
        msguser.style.display = 'block';
    }
    else{
        msguser.style.display = 'none';

    }
});

pass.addEventListener('blur', function(e){
    if(pass.value.length == 0){
        msgpass.style.display = 'block';
    }
    else{
        msgpass.style.display = 'none';

    }
});

usuario.addEventListener('keyup',function(e){
    if(usuario.value.length == 0){
        msguser.style.display = 'block';
    }
    else{
        msguser.style.display = 'none';

    }
});
pass.addEventListener('keyup', function(e){
    if(pass.value.length == 0){
        msgpass.style.display = 'block';
    }
    else{
        msgpass.style.display = 'none';

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