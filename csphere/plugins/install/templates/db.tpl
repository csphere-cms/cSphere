<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=db *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/database *}" method="POST">

            <div class="form-group">
                <label for="inputDatabaseDriver" class="col-sm-2 control-label">{* lang server *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="inputDatabaseDriver" name="database_driver">
                    {* foreach database.drivers *}
                    {* if drivers.active == 'yes' *}
                        <option value="{* var drivers.short *}" selected="selected">{* var drivers.name *}</option>
                    {* else drivers.active *}
                        <option value="{* var drivers.short *}">{* var drivers.name *}</option>
                    {* endif drivers.active *}
                    {* endforeach database.drivers *}
                    </select>
                </div>
            </div><!--END form form-group inputDatabaseDriver-->

            <div class="sql_others">
            {* tpl default/com_input_adv name=database_host label=default.host value=database.host type=text holder=host_info *}

            {* tpl default/com_input_adv name=database_user label=users.user_name value=database.username type=text holder=users.user_name *}

            {* tpl default/com_input_pwd name=database_pass label=default.password holder=default.password *}
            </div>

            {* tpl default/com_input_adv name=database_prefix label=db_prefix value=database.prefix type=text holder=db_prefix_info *}

            <div class="sql_others">
            {* tpl default/com_input_adv name=database_schema label=db_schema value=database.schema type=text holder=db_schema_info *}
            </div>

            <div class="sql_filename">
            {* tpl default/com_input_adv name=database_file label=db_file value=database.file type=text holder=db_file_info *}
            </div>

            {* tpl default/com_submit_btn caption=test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->