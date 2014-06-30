<div class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=users.users action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=users.users action=default.edit *}
        {* endif action *}

        <br>

        {* if action == 'create' *}
        <form role="form" action="{* link users/create *}" method="POST">
        {* else action *}
        <form role="form" action="{* link users/edit/id/$users.user_id *}" method="POST">
        {* endif action *}

            {* tpl default/com_input name=user_name label=users.user_name value=users.user_name *}

            {* if users.user_active == '1' *}
            {* tpl default/com_input_yesno name=user_active label=users.active *}
            {* else users.user_active *}
            {* tpl default/com_input_noyes name=user_active label=users.active *}
            {* endif users.user_active *}

            {* tpl default/com_input_adv name=user_email label=default.email value=users.user_email type=email holder=default.email *}

            {* if action == 'create' *}
            {* tpl default/com_input_pwd name=user_password label=default.password holder=default.password *}
            {* endif action *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
