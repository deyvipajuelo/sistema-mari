<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="portada">
    
        <img src="{{URL::asset('img/oficio.jpg')}}" alt="img" class="fondo">

        <div>
            <p class="fecha texto">Huaraz, {{$dia}} de {{$mes}} de {{$year}}</p>
            <p class="texto num_oficio">{{$registro->numero_oficio}}</p>
            <p class="texto saludo">Señor (a):</p>
            <p class="texto jefe">{{$registro->jefe}}</p>
            <p class="texto bloque-uno">Jefe (e) de la Oficina Desconcentrada de Control de la Magistratura<br>Corte Superior de Justicia de Ancash</p>
            <p class="texto ref">Ref.:	<span class="ref-contenido">{{$registro->ref}}</span></p>
            <p class="texto bloque-dos">Tengo el honor de dirigirme a usted y saludarle cordialmente, y en atención al documento de la referencia, remitirle adjunto EXP. N° <span class="queja">{{$registro->num_expediente}}</span>, proceso seguido contra {{$registro->demandado}}, por el delito de: {{$registro->queja}}, conforme ha sido solicitado por su Despacho.</p>
            <p class="texto bloque-tres">Asimismo, solicitarle muy respetuosamente tenga a bien ordenar a quien corresponda, <span class="dos-negrita">para su devolución considerar la ubicación, Anaquel: <span class="num-anaquel">{{$registro->anaquel}}</span> Paquete: <span class="num-paquete">{{$registro->paquete}}</span>.</span></p>
            <p class="texto bloque-cuatro">Hago propicia la oportunidad para expresarle las muestras de mi especial consideración y estima  personal.</p>
            <p class="texto atte">Atentamente,</p>
        </div>

    </div>
</body>
</html>
<style>
    .atte{
        font-style: italic;
        text-indent: 10px;
        margin-top: 20px;
    }
    .queja{
        font-weight:  bolder;
        font-style: italic;
    }
    .bloque-cuatro{
        margin-top: 20px;
    }
    .dos-negrita{
        font-weight:  bolder;
        font-style: italic;
    }
    .bloque-tres{
        margin-top: 20px;
    }
    .bloque-dos{
        margin-top: 20px;
        text-indent: 65px;
    }
    .ref-contenido{
        margin-left: 30px;
    }
    .ref{
        margin-top: 20px;
    }
    .bloque-uno{
        margin-top: 3px;
    }
    .jefe{
        margin-top: 3px;
        font-weight:  bolder;
    }
    .saludo{
        margin-top: 20px;
    }

.num_oficio{
    margin-top: 20px;
    text-decoration: underline;
    font-weight:  bolder;
    font-style: italic;
}
.fecha{
    margin-top: 235px;
}


.texto{
    margin-left: 112px;
    margin-right: 105px;
    text-align: justify;
    line-height : 20px;
}

.fondo {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  z-index: -100;
}




    html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}

article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

</style>