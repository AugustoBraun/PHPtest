    <button class="btn-busca-cep-pop" onClick="popBusca();"><span>+</span>Buscar CEP</button>

    <div id="pop-busca-cep">
         <input  type="text" id="field-busca-cep" name="field-busca-cep" placeholder="00000-000" class="field-busca-cep"  maxlength="9" size="9" onkeypress="mascara(this, '#####-###')">
         <button name="btn-busca-cep" id="btn-busca-cep" onClick="executaBusca();">Buscar</button>
         <!-- <img src="/dist/img/close.png" class="close"> -->
        <div id="close-pop" class="close-btn" onClick="closePop(this);">X</div>
    </div>

    <section>
        <div class="container">

            <table class="table" id="cep-table-wrap">
            <thead>
            <tr>
                <th>ID</th>
                <th>CEP</th>
                <th>Logradouro</th>
                <th>bairro</th>
                <th>localidade</th>
                <th>uf</th>
                <th>download</th>
            </tr>
            </thead>
            <tbody id="cep-table">
            <?php

            if(!empty($listacep))
            {
                foreach($listacep as $k=>$v)
                {
                    $cep = substr($v['cep'],0,5).'-'.substr($v['cep'],-3);

                    echo '
                        <tr id="cepid-'.$v['cepId'].'">
                            <td>'.$v['cepId'].'</td>       
                            <td>'.$cep.'</td>       
                            <td>'.$v['logradouro'].'</td>       
                            <td>'.$v['bairro'].'</td>       
                            <td>'.$v['localidade'].'</td>       
                            <td>'.$v['uf'].'</td>       
                            <td><img src="/dist/img/ico/24/abaixo.png" class="dld-img" id="xmlid-'.$v['cepId'].'" onClick="baixaXml(this);"></td>       
                        </tr>
                        ';
                }
            }
            
            ?>
            </tbody>
            </table>

        </div>
    </section>

        

    <!-- html prototipo para construçao das linhas -->

    <table class="invisible">
        <tr id="line-prototype">
            <td>###cepid###</td>       
            <td>###cep###</td>       
            <td>###logradouro###</td>       
            <td>###bairro###</td>       
            <td>###localidade###</td>       
            <td>###uf###</td>       
            <td><img src="/dist/img/ico/24/abaixo.png" class="dld-img"></td>       
        </tr>
    </table>