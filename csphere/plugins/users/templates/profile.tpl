<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users action=profile *}

        <br />

        <form class="form-horizontal" role="form" action="{* link users/profile *}" method="POST">

            {* tpl default/com_input name=user_name label=name value=users.user_name *}

            {* tpl default/com_input_adv name=user_email label=email value=users.user_email type=email holder=email *}

            {* tpl default/com_input_pwd name=password_old label=password holder=password_old *}

            {* tpl default/com_input_pwd name=password_new label=password holder=password_new *}

            {* tpl default/com_input_pwd name=password_confirm label=password holder=password_confirm *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->