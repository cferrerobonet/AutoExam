//Subir a produccion
//var web = "http://david.i-seo";
var web = "http://www.i-seo.com";

function cambiarVistaKeywords(dominio,tiempo,palabras,criterio,orden){
    var newurl = web+'/informe/keywords/'+dominio+'/'+tiempo+'/'+palabras+'/'+criterio+'/'+orden;
    window.location=newurl;
}

function cambiarVistaCompetencia(dominios,keywords,elegida,periodo){
	var newurl = web+'/informe/competencia_keywords/'+dominios+'/'+keywords+'/'+elegida+'/'+periodo;
	window.location=newurl;
}

function ordenarInformeBacklinksPrivados(criterio,orden){
    var newurl = web+'/informe/private_backlinks/'+criterio+'/'+orden;
    window.location=newurl;
}

function cambiarVistaGoogleBacklinks(dominio,tiempo){
    var newurl = web+'/informe/google_backlinks/'+dominio+'/'+tiempo;
    window.location=newurl;
}

function cambiarVistaGooglePagerank(dominio,tiempo){
    var newurl = web+'/informe/google_pagerank/'+dominio+'/'+tiempo;
    window.location=newurl;
}

function aniadirDominio(nombreDominio,tipoDominio,dominiosEvaluacion,dominiosLink){
    var palabras=nombreDominio.split(" ");
    var dominio;

    if(nombreDominio){
        if(nombreDominio.indexOf(" ",0)!=(-1)){
            for(i=0; i<palabras.length;i++){
                dominio = dominio + palabras[i];
            }
        } else
            dominio = nombreDominio;

        newurl = web+'/gestion/aniadir_dominio/'+dominio+'/'+tipoDominio+'/'+dominiosEvaluacion+'/'+dominiosLink;
    } else
        newurl = web+'/gestion/dominios';

    window.location=newurl;
}

function permutarNotas(){
    if($('notas').style.display=="none")
        new Effect.Appear('notas');
    else
        new Effect.Fade('notas');
}

function permutarCalendario(){
    if($('calendario').style.display=="none")
        $('calendario').style.display="";
    else
        $('calendario').style.display="none";
}

function cambiarVariacionResumen(variacion){
    var newurl = web+'/informe/resumen/'+variacion;
    window.location=newurl;
}

function actualizarA(dominio,plan){
    var newurl = web+'/gestion/actualizar_plan/'+dominio+'/'+plan+'/seleccionado';
    window.location=newurl;
}

function cambiarUsuarioSuplantado(usuarioId){
	var newurl = web+'/gestion/suplantar_usuario/'+usuarioId;
	window.location=newurl;
}
