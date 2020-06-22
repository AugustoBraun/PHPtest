function ajax_get(url, callback) {
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // console.log('responseText:' + xmlhttp.responseText);
            try {                
                var data = JSON.parse(xmlhttp.responseText);
            } catch(err) {
                console.log(err.message + " in " + xmlhttp.responseText);
                return;
            }
            callback(data);
        }
    };
 
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
 


function popBusca(){

    abreMensagens('pop-busca-cep');
    
}


function executaBusca()
{
    var cepField = document.getElementById('field-busca-cep');
    var cep = document.getElementById('field-busca-cep').value;    
    cep = cep.replace(/\.|\-/g, '');
    
    if(cep.length < 8)
    {
        alert('Informe o CEP completo com os 8 dítigos');
        cepField.focus();        
        return false;
    }

    ajax_get('/sistema/buscacep/consultar/' + cep, function(data) 
    {
        console.log(data);

        if(data[0] == '400')
        {
            alert('Este CEP não existe');
            fechaMensagens('pop-busca-cep');
            return false;
        }

        if ('existe' in data) 
        {
            var existId = data.existe;  
            var scrollId = document.getElementById('cepid-'+existId);
            scrollId.scrollIntoView();
            var table = document.getElementById("cep-table-wrap");
            for (var i = 0, row; row = table.rows[i]; i++) {
                table.rows[i].style.backgroundColor = 'transparent';
            }
            setTimeout(function()
            {    
                scrollId.style.backgroundColor = '#c3dfa7';
            },100);            
            fechaMensagens('pop-busca-cep');
            return false;
        }

        var theParent = document.getElementById("cep-table");
        var newline = document.getElementById("line-prototype");
        newline = newline.outerHTML;
        newline = newline.replace('id="line-prototype"', '');
        newline = newline.replace('###cepid###', data['cepId']);
        newline = newline.replace('###cep###', data['cep']);
        newline = newline.replace('###logradouro###', data['logradouro']);
        newline = newline.replace('###bairro###', data['bairro']);
        newline = newline.replace('###localidade###', data['localidade']);
        newline = newline.replace('###uf###', data['uf']);

        var elChild = document.createElement('tr');
        elChild.innerHTML = newline;
        
        var first = document.getElementById("cep-table").rows[0].getAttribute('id');

        theParent.insertBefore(elChild, theParent.firstChild);

        var table=document.getElementById("cep-table-wrap");
        for (var i = 0, row; row = table.rows[i]; i++) {
            table.rows[i].style.backgroundColor = 'transparent';
        }

        setTimeout(function()
        {    
            elChild.style.backgroundColor = '#c3dfa7';
            fechaMensagens('pop-busca-cep');
        },100);

    });

}



function position(elem) { 
    var left = 0, 
        top = 0; 

    do { 
        left += elem.offsetLeft-elem.scrollLeft; 
        top += elem.offsetTop-elem.scrollTop; 
    } while ( elem = elem.offsetParent ); 

    return [ left, top ]; 
} 


function mascara(t, mask){
    var i = t.value.length;
    var saida = mask.substring(1,0);
    var texto = mask.substring(i)
    if (texto.substring(0,1) != saida){
        t.value += texto.substring(0,1);
    }
}


function baixaXml(e)
{
    var xmlId = e.getAttribute('id').split('-')[1];
    var win = window.open('/sistema/buscacep/baixa_xml/' + xmlId + '?carrega_template=nao', '_blank');
    win.focus();
 
}



function closePop()
{
    fechaMensagens('pop-busca-cep');
}
