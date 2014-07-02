<div class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=groups.groups action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=groups.groups action=default.edit *}
        {* endif action *}

        <br>

        {* if action == 'create' *}
        <form role="form" action="{* link groups/create *}" method="POST">
        {* else action *}
        <form role="form" action="{* link groups/edit/id/$groups.group_id *}" method="POST">
        {* endif action *}

            {* tpl default/com_input name=group_name label=default.name value=groups.group_name holder=default.name *}

            {* tpl default/com_input name=group_url label=groups.url value=groups.group_url holder=groups.url *}

            {* tpl default/com_textarea name=group_info label=default.info rows=3 value=groups.group_info holder=default.info *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
