<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users.users action=users.settings *}

        <br>

        <form class="form-horizontal" role="form" action="{* link users/settings *}" method="POST">

            {* if users.user_invisible == '1' *}
            {* tpl default/com_input_yesno name=user_invisible label=users.invisible *}
            {* else users.user_invisible *}
            {* tpl default/com_input_noyes name=user_invisible label=users.invisible *}
            {* endif users.user_invisible *}

            {* tpl default/com_select name=user_lang label=users.language options=users.languages *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
