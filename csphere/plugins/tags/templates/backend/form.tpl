<div class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=tags.tags action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=tags.tags action=default.edit *}
        {* endif action *}

        <br>

        {* if action == 'create' *}
        <form role="form" action="{* link tags/create *}" method="POST">
        {* else action *}
        <form role="form" action="{* link tags/edit/id/$tags.tag_id *}" method="POST">
        {* endif action *}

            {* tpl default/com_input name=tag_name label=default.name value=tags.tag_name holder=default.name *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
