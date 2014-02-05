<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.db *}

        <br>

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/db *}" method="POST">

            {* tpl default/com_select name=database_driver label=install.server options=database.drivers *}

            <div class="sql_others">
            {* tpl default/com_input_adv name=database_host label=default.host value=database.host type=text holder=install.host_info *}

            {* tpl default/com_input_adv name=database_user label=users.user_name value=database.username type=text holder=install.user_name *}

            {* tpl default/com_input_pwd name=database_pass label=default.password holder=default.password *}
            </div>

            {* tpl default/com_input_adv name=database_prefix label=install.db_prefix value=database.prefix type=text holder=install.db_prefix_info *}

            <div class="sql_others">
            {* tpl default/com_input_adv name=database_schema label=install.db_schema value=database.schema type=text holder=install.db_schema_info *}
            </div>

            <div class="sql_filename">
            {* tpl default/com_input_adv name=database_file label=install.db_file value=database.file type=text holder=install.db_file_info *}
            </div>

            {* tpl default/com_submit_btn caption=install.test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->