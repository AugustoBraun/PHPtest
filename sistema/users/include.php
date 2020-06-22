<?php

    $tab= 1;
    if(!$funcao)
        $funcao = 'include';

//echo '<pre>';
//print_r($status);


?>
    <link rel="stylesheet" href="/css/admin_url.css">
    <script>

        function submeter()
        {
            var field = $('#field_url').val().trim();
            if(field.length <= 0)
            {
                alert('Insira uma URL');
                return false;
            }
            document.forms['formulario1'].submit();
        }

    </script>

    <table width="100%" border="0" cellspacing="0" cellpadding="15">
        <tr>
            <td>
                <form method="post" action="<?php echo ADMINURL; ?>url/<?php echo $funcao ?>" name="formulario1" id="formulario1" enctype="multipart/form-data">




                    <label>Informe a URL:</label>
                    <br>
                    <input
                        type="text"
                        name="field_url"
                        id="field_url"
                        size="100"
                        tabindex="<?php echo $tab++; ?>"
                        value="<?php if(isset($info['field_url'])){echo StripSlashes(htmlentities($info['field_url']));}
                    ?>" placeholder="ex.: https://google.com" >



                    <hr class="hr_separador">



                    <div align="center"> <b>
                            <input type="button" name="incluir" onClick="submeter();" value="<?php if($funcao=='edit'){echo 'editar'; }else{ echo 'incluir'; } ?> URL" class="botao_padrao">
                        </b></div>
                </form>
            </td>
        </tr>
    </table>
<?php

    $_SESSION['adminUser']['info_page'] = array();
    $_SESSION['adminUser']['info_content'] = array();

?>