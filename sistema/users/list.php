<style>

    .users-table-list{
        width:100%;
    }
    .users-table-list tr td{
        padding: 15px;
        border-left: 1px solid #555 !important;
        cursor: pointer;
    }

    tr:nth-child(even){
        background-color: #eaeaea;
    }
</style>



<form action="/sistema/users/order" method="POST">

    <div class="filters-wrap">
        <label>Ordenar por:</label>
        <select name="filter-by">
            <option value="name">Name</option>
            <option value="username">Username</option>
            <option value="email">Email</option>
            <option value="phone">Phone</option>
        </select><br>

        <div class="option">
            <input type="radio" name="vector" value="asc" checked>
            <label>Crescente</label><br>
        </div>

        <div class="option">
            <input type="radio" name="vector" value="desc">
            <label>Decrescente</label>
        </div>

        <div class="apply-wrap">
            <input type="submit" name="apply" class="apply" value="aplicar">
        </div>






    </div>

</form>
        <table class="users-table-list" cellspacing="0" id="tabela_editar">
            <thead>
                <tr>
                    <th width="20%" id="name">Name:</th>
                    <th width="20%" id="username">Username:</th>
                    <th width="25%" id="email">E-mail:</th>
                    <th width="30%" id="phone">Phone:</th>
                    <th width="5%" id="info">Info:</th>
                </tr>
            </thead>
            <tbody>
            <?php

                if(!empty($users) && is_array($users))
                {
                    foreach($users as $k => $v)
                    {
                        echo '<tr class="user-item"
                                    data-name="'.$v['name'].'"
                                    data-username="'.$v['username'].'"
                                    data-email="'.$v['email'].'"
                                    data-phone="'.$v['phone'].'"
                                    data-street="'.$v['address']['street'].'"
                                    data-suite="'.$v['address']['suite'].'"
                                    data-city="'.$v['address']['city'].'"
                                    data-zipcode="'.$v['address']['zipcode'].'"
                                    data-geo-lat="'.$v['address']['geo']['lat'].'"
                                    data-geo-lng="'.$v['address']['geo']['lng'].'"
                                    data-website="'.$v['website'].'"
                                    data-company-name="'.$v['company']['name'].'"
                                    data-company-catchphrase="'.$v['company']['catchPhrase'].'"
                                    data-company-bs="'.$v['company']['bs'].'"
                                    >
                                <td>'.$v['name'].'</td>
                                <td>'.$v['username'].'</td>
                                <td>'.$v['email'].'</td>
                                <td>'.$v['phone'].'</td>
                                <td align="center"><img src="/sistema/img/info.png" height="24"></td>
                                </tr>
                                ';

                    }
                }

            ?>
            </tbody>
        </table>
<div class="proto-modal">
    <div class="modal-name"></div>
    <div class="modal-username"></div>
    <div class="modal-email"></div>
    <div class="modal-website"></div>
    <div class="modal-phone"></div>
    <div class="modal-address"></div>
    <div class="modal-company"></div>
</div>
<script>

    $(document).ready(function(){

        $('.user-item').click(function(){

            console.log($(this).data('name'));
            var el = $('.proto-modal');
            el.find('.modal-name').html('<h1>' + $(this).data('name') + '</h1>');
            el.find('.modal-username').html('User Name:  <span>' + $(this).data('username') + '</span>');
            el.find('.modal-email').html('E-mail:  <span>' + $(this).data('email') + '</span>');
            el.find('.modal-website').html('Website:  <span>' + $(this).data('website') + '</span>');
            el.find('.modal-phone').html('Phone:  <span>' + $(this).data('phone') + '</span>');
            el.find('.modal-address').html('Address:  <span>' + $(this).data('street') + ',  ' +
                $(this).data('suite') + ',  ' +
                $(this).data('city') + ',  ' +
                $(this).data('zipcode')  +
                '</span>');
            el.find('.modal-company').html('Company:  <span>' + $(this).data('company-name') + ',  ' +
                $(this).data('company-catchphrase') + ',  ' +
                $(this).data('company-bs')  +
                '</span>');

            el.fadeIn('fast');


        });


       /* $('.users-table-list th').click(function(){
            var column = $(this).attr('id');
            var vector = $(this).attr('data-vector');
            if(column == 'info')
                return false;


            var sendData = {
                column: column,
                vector: vector
            }

            $.post('/sistema/users/order', sendData, function(data){
                console.log(data);
            });

        });*/

    });

    $(document).click(function(event) {
        if (!$(event.target).closest(".user-item").length) {
            $("body").find(".proto-modal").fadeOut('fast');
        }
    });

</script>