(function(){
    
    var actualizarHora = function()
    {
        
        var fecha = new Date(),
        horas = fecha.getHours(),
        ampm,
        minutos = fecha.getMinutes(),
        segundos = fecha.getSeconds(),
        diaSemana = fecha.getDay(),
        dian = fecha.getDate(),
        mes = fecha.getMonth(),
        year = fecha.getFullYear();

        //Aquí va el get para la fecha

        var pdiaSemana = document.getElementById('diaSemana'),
            pdian = document.getElementById('dian'),
            pAmPm = document.getElementById('ampm'),
            pmes = document.getElementById('mes'),
            pyear = document.getElementById('year'),
            phoras = document.getElementById('horas'),
            pminutos = document.getElementById('minutos'),
            psegundos = document.getElementById('segundos');
        var semana = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        
            pdiaSemana.textContent = semana[diaSemana];
            pdian.textContent = dian;
        var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            pmes.textContent = meses[mes];
            pyear.textContent = year;
        //condiciones para tener el reloj de 12 horas
        if (horas >= 12) {
            ampm = 'PM';
            if (horas > 12) {
                horas = horas - 12; // Si las horas son mayores a 12, conviértelas a formato de 12 horas
            }
        } else {
            ampm = 'AM';
            if (horas == 0) {
                horas = 12; // Si son las 12 de la madrugada, cámbialo a 12:00 AM
            }
        }
        phoras.textContent = horas;
        pAmPm.textContent = ampm;

        if(minutos <10){ minutos = "0"+ minutos};
        if(segundos<10){segundos = "0" + segundos};
        pminutos.textContent = minutos;
        psegundos.textContent = segundos;
        









    };
    actualizarHora();
    var intervalo = setInterval(actualizarHora,1000);


}())