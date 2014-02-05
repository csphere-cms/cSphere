<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.webmaster *}

        <br>

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/webmaster *}" method="POST">

            {* tpl default/com_input_adv name=user_name label=install.user_name value=user_name type=text holder=install.user_name *}

            {* tpl default/com_input_adv name=user_email label=default.email value=user_email type=email holder=default.email *}

            {* tpl default/com_input_pwd name=user_password label=default.password holder=default.password *}

            {* tpl default/com_input_pwd name=user_password_confirm label=default.password_confirm holder=default.password_confirm *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->