<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users.users action=users.login *}

        <br>

        <form role="form" action="{* link users/login *}" name="form_login" method="POST">

            {* tpl default/msg_error *}

            {* tpl default/com_input name=login_name label=users.user_name value=login_name holder=users.user_name  *}

            {* tpl default/com_input_pwd name=login_password label=users.user_password holder=users.user_password *}

            {* tpl default/com_submit_btn caption=users.submit *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
