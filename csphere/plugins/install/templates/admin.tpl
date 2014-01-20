<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=admin *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/admin *}" method="POST">

            {* tpl default/com_input_adv name=user_name label=name value=user_name type=text holder=name *}

            {* tpl default/com_input_adv name=user_email label=default.email value=user_email type=email holder=default.email *}

            {* tpl default/com_input_pwd name=user_password label=default.password holder=default.password *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->