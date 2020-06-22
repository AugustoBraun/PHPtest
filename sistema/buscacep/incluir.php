     <button class="btn-add-task"><span>+</span>Adicionar produto</button>

        <table class="table-produtos" cellspacing="0" id="tabela_editar">
            <?php
                if($_SESSION['device'] != 'phone') {
                    ?>
                    <thead>
                    <tr id="header-line">
                        <th width="5%">ID:</th>
                        <th width="20%">Nome da produto:</th>
                        <th width="10%">Status:</th>
                        <th width="10%">Início:</th>
                        <th width="10%">Fim:</th>
                        <th width="30%">Descrição</th>
                        <th width="5%" nowrap>Excluir:</th>
                    </tr>
                    </thead>
                    <?php
                }
            ?>
            <tbody>
            <?php

                if(!empty($produtos) && is_array($produtos))
                {
                    foreach($produtos as $k => $v)
                    {
                        $status = '<div class="status Iniciada">Iniciada</div>';
                        if($v['produtoStatus'] == 'f')
                            $status = '<div class="status Finalizada">Finalizada</div>';

                        if($_SESSION['device'] != 'phone') {

                            echo '<tr id="line-' . $v['produtoId'] . '" data-produto="' . $v['produtoId'] . '" class="produto-line" valign="top">
                                    <td align="center">' . $v['produtoId'] . '</td>
                                    <td><input type="text" name="produtoNome" placeholder="Informe o nome da produto" value="' . $v['produtoNome'] . '"></td>
                                    <td align="center">' . $status . '</td>
                                    <td><input type="text" class="data-inicio" name="produtoInicio" value="' . $v['produtoInicio'] . '"></td>
                                    <td><input type="text" class="data-fim" name="produtoFim" value="' . $v['produtoFim'] . '"></td>
                                    <td><textarea name="produtoDescricao" class="field-descricao" rows="10">' . $v['produtoDescricao'] . '</textarea></td>
                                    <td align="center" class="line-btns">
                                            <a href="javascript://" class="tooltip" onClick="
                                                    confirmaCallback(\'Confirma Exclusão da produto ID  <font color=999999> ' . htmlentities($v['produtoId'], ENT_QUOTES) . '</font>?\',
                                                    deletaproduto, \'' . $v['produtoId'] . '\');">
                                                    <img src="/sistema/img/icones/16_excluir.png">
                                                    <span>Excluir produto ID ' . $v['produtoId'] . '</span>
                                            </a>
                                        </td>
                                    </tr>';

                        }else{


                            echo '<tr id="line-'. $v['produtoId'] .'" data-produto="'. $v['produtoId'] .'" class="produto-line mobile-line" valign="top">
                                    <td>
                                        <div class="mobile-id">ID '. $v['produtoId'] .'</div>
                                        <div class="mobile-nome">
                                            <input type="text" name="produtoNome" placeholder="Informe o nome da produto" value="' . $v['produtoNome'] . '">
                                        </div>
                                        <div class="mobile-status">
                                            '.$status.'
                                        </div>
                                        <div class="mobile-inicio">
                                            <input type="text" name="produtoInicio" class="data-inicio" value="' . $v['produtoInicio'] . '" placeholder="Início">
                                        </div>
                                        <div class="mobile-fim">
                                            <input type="text" name="produtoFim" class="data-fim" value="' . $v['produtoFim'] . '"  placeholder="Fim">
                                        </div>
                                        <div class="mobile-descricao">
                                            <textarea name="produtoDescricao" class="field-descricao" rows="10"  placeholder="Descrição da produto">'.$v['produtoDescricao'].'</textarea>
                                        </div>
                                        <div class="mobile-deletar" class="line-btns">
                                            <a href="javascript://" class="tooltip" onClick="
                                                    confirmaCallback(\'Confirma Exclusão da produto ID <font color=999999>'.htmlentities($v['produtoId'], ENT_QUOTES).'</font>?\',
                                                        deletaProduto,\'' . $v['produtoId'] . '\');">
                                                <img src="/sistema/img/icones/16_excluir.png">
                                                <span>Excluir produto ID ' . $v['produtoId'] . '</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>';


                        }

                    }
                }

            ?>
            </tbody>
        </table>
        <script>


            $(document).ready(function()
            {

                var produtoId;
                var produtoNome;
                var produtoInicio;
                var produtoFim;
                var produtoDescricao;

                $(".data-inicio").datepicker({
                    onSelect: function(selectedDate) {
                        produtoInicio = selectedDate;
                        gravaData(produtoInicio,'Inicio');
                    }
                });
                $(".data-fim").datepicker({
                    onSelect: function(selectedDate) {
                        produtoFim = selectedDate;
                        gravaData(produtoFim,'Fim');
                    }
                });

                //gera uma nova produto vazia, retorna o novo ID e aguarda dados para edição dinamica
                $('.btn-add-task').click(function()
                {
                    //recupera a proxima ocorrencia do banco de dados de produtos
                    $.get('/sistema/produtos/criaProduto',function(data)
                    {
                        var new_id = data;
                        var new_line = $('#proto-line').prop('outerHTML');
                        new_line = replaceAll(new_line,'##novaprodutoid##',new_id);
                        new_line = replaceAll(new_line,'proto-line','line-' + new_id);
                        $('#tabela_editar tbody').prepend(new_line);
                    });
                });


                //alterna o status da produto, grava no banco e adiciona data do click em caso de finalizada
                $('.status').click(function(e)
                {
                    var element = $(this);
                    var status = element.text();
                    var new_status = 'Iniciada';
                    var produtoId = element.parents('.produto-line').attr('id').split('-')[1];

                    if(status == 'Iniciada')
                        new_status = 'Finalizada';

                    var sendData = {
                        new_status: new_status,
                        produtoId: produtoId
                    };

                    $.post('/sistema/produtos/mudaStatus',sendData,function(data)
                    {
                        if(data == 'OK')
                        {
                            element.removeClass(status);
                            element.addClass(new_status);
                            element.text(new_status);
                        }else{
                            alert('Erro ao alterar Status');
                        }
                    });

                });


                $('.field-descricao').click(function(e)
                {
                    var element = $(this);
                    element.addClass('abrindo');

                });



                var $win = $(window);
                var $box = $(".field-descricao");
                $win.on("click.Bst", function(event)
                {
                    if ($box.has(event.target).length == 0 &&  !$box.is(event.target))
                    {
                        $('.field-descricao.abrindo').removeClass('abrindo').addClass('fechando')
                        setTimeout(function()
                        {
                            $('.field-descricao').removeClass('fechando');
                        },1000);
                    }
                });



                $('input[name="produtoNome"]').focus(function() {
                    produtoId = $(this).parents('.produto-line').attr('id').split('-')[1];
                }).blur(function() {
                    var campo = 'Nome';
                    var sendData = {
                        produtoId: produtoId,
                        valor: $(this).val(),
                        campo: campo
                    }
                    $.post('/sistema/produtos/editarCampo', sendData, function(data)
                    {
                        if(data != 'OK')
                            alert('Erro ao editar o ' + campo + ' da produto');
                    });
                });

                $('textarea[name="produtoDescricao"]').focus(function() {
                    produtoId = $(this).parents('.produto-line').attr('id').split('-')[1];
                }).blur(function() {
                    var campo = 'Descricao';
                    var sendData = {
                        produtoId: produtoId,
                        valor: $(this).val(),
                        campo: campo
                    }
                    $.post('/sistema/produtos/editarCampo', sendData, function(data)
                    {
                        if(data != 'OK')
                            alert('Erro ao editar o ' + campo + ' do produto');
                    });
                });

                function gravaData(data,campo)
                {
                    var sendData = {
                        produtoId: produtoId,
                        valor: data,
                        campo: campo
                    }
                    $.post('/sistema/produtos/editarCampo', sendData, function(data)
                    {
                        if(data != 'OK')
                            alert('Erro ao editar o ' + campo + ' do produto');
                    });
                }

                $('input[name="produtoInicio"]').focus(function() {
                    produtoId = $(this).parents('.produto-line').attr('id').split('-')[1];
                });

                $('input[name="produtoFim"]').focus(function() {
                    produtoId = $(this).parents('.produto-line').attr('id').split('-')[1];
                });

            });



        </script>

        <!-- html prototipo para construçao das linhas -->

        <?php
            if($_SESSION['device'] != 'phone') {
        ?>
                <table style="display:none;">
                    <tr id="proto-line" data-produto="##novaprodutoid##" class="produto-line" valign="top">
                        <td align="center">##novaprodutoid##</td>
                        <td><input type="text" name="produtoNome" placeholder="Informe o nome da produto"></td>
                        <td align="center">
                            <div class="status Iniciada">Iniciada</div>
                        </td>
                        <td><input type="text" name="produtoInicio" class="data-inicio"></td>
                        <td><input type="text" name="produtoFim" class="data-fim"></td>
                        <td><textarea name="produtoDescricao" class="field-descricao" rows="10"></textarea></td>
                        <td align="center" class="line-btns">
                            <a href="javascript://" class="tooltip" onClick="
                                                                    confirmaCallback('Confirma Exclusão da produto ID <font color=999999>##novaprodutoid##</font>?',
                                                                    deletaProduto,'##novaprodutoid##');">
                                <img src="/sistema/img/icones/16_excluir.png">
                                <span>Excluir produto ID ##novaprodutoid##</span>
                            </a>
                        </td>
                    </tr>
                </table>
        <?php
            }else{
        ?>

                <table style="display:none;">
                    <tr id="proto-line" data-produto="##novaprodutoid##" class="produto-line mobile-line" valign="top">
                        <td>
                            <div class="mobile-id">##novaprodutoid##</div>
                            <div class="mobile-nome">
                                <input type="text" name="produtoNome" placeholder="Informe o nome da produto">
                            </div>
                            <div class="mobile-status">
                                <div class="status Iniciada">Iniciada</div>
                            </div>
                            <div class="mobile-inicio">
                                <input type="text" name="produtoInicio" class="data-inicio"  placeholder="Início">
                            </div>
                            <div class="mobile-fim">
                                <input type="text" name="produtoFim" class="data-fim"  placeholder="Fim">
                            </div>
                            <div class="mobile-descricao">
                                <textarea name="produtoDescricao" class="field-descricao" rows="10" placeholder="Descrição da produto"></textarea>
                            </div>
                            <div class="mobile-deletar" class="line-btns">
                                <a href="javascript://" class="tooltip" onClick="
                                                                        confirmaCallback('Confirma Exclusão da produto ID <font color=999999>##novaprodutoid##</font>?',
                                                                        deletaProduto,'##novaprodutoid##');">
                                    <img src="/sistema/img/icones/16_excluir.png">
                                    <span>Excluir Produto ID ##novaprodutoid##</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>


        <?php
            }
        ?>


