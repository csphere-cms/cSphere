<div class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=members action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=members action=default.edit *}
        {* endif action *}

        <br />

        {* if action == 'create' *}
        <form class="form-horizontal" role="form" action="{* link members/create *}" method="POST">
        {* else action *}
        <form class="form-horizontal" role="form" action="{* link members/edit/id/$members.member_id *}" method="POST">
        {* endif action *}

            {* tpl default/com_input name=group_name label=group_name value=members.group_name *}

            {* tpl default/com_input name=user_name label=user_name value=members.user_name *}

            {* if members.member_admin == '1' *}
            {* tpl default/com_input_yesno name=member_admin label=group_admin *}
            {* else members.member_admin *}
            {* tpl default/com_input_noyes name=member_admin label=group_admin *}
            {* endif members.member_admin *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->