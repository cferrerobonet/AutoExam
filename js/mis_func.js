var numresp;
var numpreg;
var quedan_mins;
var quedan_secs;
var cadajax = '';
var timer;
var opcion;
var clic;

function Crono(hora_ini, hora_actual, duracion){

    miFecha = new Date();
    miFecha2 = new Date();

    var aux = hora_ini + '';
    var aux2 = hora_actual + '';

    if(aux[4] == '0'){
        if(aux[6] == '0')
            miFecha2.setFullYear(aux[0] + '' + aux[1] + '' + aux[2] + '' + aux[3] + '', aux[5] - 1, aux[7]);
        else
            miFecha2.setFullYear(aux[0] + '' + aux[1] + '' + aux[2] + '' + aux[3] + '', aux[5] - 1, aux[6] + '' + aux[7]);
    }
    else{
        if(aux[6] == '0')
            miFecha2.setFullYear(aux[0] + '' + aux[1] + '' + aux[2] + '' + aux[3] + '', (aux[4] + '' + aux[5]) - 1, aux[7]);
        else
            miFecha2.setFullYear(aux[0] + '' + aux[1] + '' + aux[2] + '' + aux[3] + '', (aux[4] + '' + aux[5]) - 1, aux[6] + '' + aux[7]);
    }

    if(aux[8] == '0'){
        if(aux[10] == '0'){
            if(aux[12] == '0')
                miFecha2.setHours(aux[9], aux[11], aux[13], 0);
            else
                miFecha2.setHours(aux[9], aux[11], aux[12] + '' + aux[13], 0);
        }
        else{
            if(aux[12] == '0')
                miFecha2.setHours(aux[9], aux[10] + '' + aux[11], aux[13], 0);
            else
                miFecha2.setHours(aux[9], aux[10] + '' + aux[11], aux[12] + '' + aux[13], 0);
        }
    }
    else{
        if(aux[10] == '0'){
            if(aux[12] == '0')
                miFecha2.setHours(aux[8] + '' + aux[9], aux[11], aux[13], 0);
            else
                miFecha2.setHours(aux[8] + '' + aux[9], aux[11], aux[12] + '' + aux[13], 0);
        }
        else{
            if(aux[12] == '0')
                miFecha2.setHours(aux[8] + '' + aux[9], aux[10] + '' + aux[11], aux[13], 0);
            else
                miFecha2.setHours(aux[8] + '' + aux[9], aux[10] + '' + aux[11], aux[12] + '' + aux[13], 0);
        }
    }

    if(aux2[4] == '0'){
        if(aux2[6] == '0')
            miFecha.setFullYear(aux2[0] + '' + aux2[1] + '' + aux2[2] + '' + aux2[3] + '', aux2[5] - 1, aux2[7]);
        else
            miFecha.setFullYear(aux2[0] + '' + aux2[1] + '' + aux2[2] + '' + aux2[3] + '', aux2[5] - 1, aux2[6] + '' + aux2[7]);
    }
    else{
        if(aux2[6] == '0')
            miFecha.setFullYear(aux2[0] + '' + aux2[1] + '' + aux2[2] + '' + aux2[3] + '', (aux2[4] + '' + aux2[5]) - 1, aux2[7]);
        else
            miFecha.setFullYear(aux2[0] + '' + aux2[1] + '' + aux2[2] + '' + aux2[3] + '', (aux2[4] + '' + aux2[5]) - 1, aux2[6] + '' + aux2[7]);
    }

    if(aux2[8] == '0'){
        if(aux2[10] == '0'){
            if(aux2[12] == '0')
                miFecha.setHours(aux2[9], aux2[11], aux2[13], 0);
            else
                miFecha.setHours(aux2[9], aux2[11], aux2[12] + '' + aux2[13], 0);
        }
        else{
            if(aux2[12] == '0')
                miFecha.setHours(aux2[9], aux2[10] + '' + aux2[11], aux2[13], 0);
            else
                miFecha.setHours(aux2[9], aux2[10] + '' + aux2[11], aux2[12] + '' + aux2[13], 0);
        }
    }
    else{
        if(aux2[10] == '0'){
            if(aux2[12] == '0')
                miFecha.setHours(aux2[8] + '' + aux2[9], aux2[11], aux2[13], 0);
            else
                miFecha.setHours(aux2[8] + '' + aux2[9], aux2[11], aux2[12] + '' + aux2[13], 0);
        }
        else{
            if(aux2[12] == '0')
                miFecha.setHours(aux2[8] + '' + aux2[9], aux2[10] + '' + aux2[11], aux2[13], 0);
            else
                miFecha.setHours(aux2[8] + '' + aux2[9], aux2[10] + '' + aux2[11], aux2[12] + '' + aux2[13], 0);
        }
    }

    var diferencia = miFecha.getTime() - miFecha2.getTime();
    var segundos = Math.floor(diferencia / 1000);
   
    quedan_mins =  Math.floor(duracion - (segundos / 60));
    quedan_secs = (Math.floor(((duracion - (segundos / 60)) - quedan_mins)*60));
    
    if(quedan_mins < 10)
        quedan_mins = '0' + quedan_mins;

    if(quedan_secs < 10)
        quedan_secs = '0' + quedan_secs;

    //Puesta en marcha del crono hacia atras
    if(quedan_mins < 10 && quedan_mins >= 0 && quedan_mins[0] != '0')
        document.getElementById('crono').innerHTML = '<h3>Tiempo: <strong>' + quedan_mins + ':' + quedan_secs + '</strong></h3>'

    timer = setInterval('Tempo()', 1000);
}


function Tempo(){
    
    quedan_secs--;

    if(quedan_secs < 0){
        quedan_secs = 59;
        quedan_mins--;
    }

    if(quedan_mins < 10 && quedan_mins >= 0 && quedan_mins[0] != '0')
        quedan_mins = '0' + quedan_mins;

    if(quedan_secs < 10 && quedan_secs[0] != '0')
        quedan_secs = '0' + quedan_secs;
    
    if(quedan_mins < 0){
        
        document.getElementById('crono').innerHTML = '<h3><strong>Fin de tiempo</strong></h3>';

        scroll(0,0);
        Sexy.alert('<h1>Test finalizado</h1><br/><p>Los resultados se han enviado al profesor.</p>');

        //Paramos el temporizador
        timer = clearInterval(timer);
        
        //Contruyo la cadena POST con las respuestas que utilizare en el ajax
        for(var i=0;i<numpreg*numresp;i++){
           if(document.forms['test'].elements[i].checked){
                opcion = Math.floor(i/numresp);
                cadajax = cadajax + 'option' + opcion + '=' + document.forms['test'].elements[i].value + '&';
           }
        }
        
        //Llamada Ajax para la correccion y volcado del test
        FAjax('entregar-test.php','todo',cadajax,'post');

        //Cambiamos el link de abortar examen, por el de salir del examen
        document.getElementById('abortar').innerHTML = '<ul><li class=\"ultimo\"><a href=\"index.php\">Salir</a></li></ul>';
    }
    else
        document.getElementById('crono').innerHTML = '<h3>Tiempo: <strong>' + quedan_mins + ':' + quedan_secs + '</strong></h3>';
}