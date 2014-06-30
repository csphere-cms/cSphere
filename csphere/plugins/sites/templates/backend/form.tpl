<div id="faqs-form" class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=sites.sites action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=sites.sites action=default.edit *}
        {* endif action *}

        <br>

        {* if action == 'create' *}
        <form role="form" action="{* link sites/create *}" method="POST">
        {* else action *}
        <form role="form" action="{* link sites/edit/id/$sites.site_id *}" method="POST">
        {* endif action *}

            {* tpl default/com_input name=site_title label=sites.title value=sites.site_title *}

            {* tpl default/com_textarea name=site_content label=sites.content rows=5 value=sites.site_content *}

            {* tpl default/com_input_tags name=site_tags label=default.tags value=sites.site_tags *}

            {* if sites.site_layout == '1' *}
            {* tpl default/com_input_yesno name=site_layout label=sites.show_layout *}
            {* else sites.site_layout *}
            {* tpl default/com_input_noyes name=site_layout label=sites.show_layout *}
            {* endif sites.site_layout *}

            {* if sites.site_publish == '1' *}
            {* tpl default/com_input_yesno name=site_publish label=sites.publish *}
            {* else sites.site_publish *}
            {* tpl default/com_input_noyes name=site_publish label=sites.publish *}
            {* endif sites.site_publish *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->
