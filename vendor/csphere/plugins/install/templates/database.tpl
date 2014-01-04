<div id="install-database" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=database *}

        <br />

        {* if error != '' *}
        <div class="alert alert-danger text-center">
            <strong>{* var error *}</strong>
        </div>

        <br />
        {* endif error *}

        <form class="form-horizontal" role="form" action="{* link install/database *}" method="POST">

            <div class="form-group">
                <label for="inputDatabaseDriver" class="col-sm-2 control-label">{* lang db_server *}</label>
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

            <div class="form-group">
                <label for="inputDatabaseHost" class="col-sm-2 control-label">{* lang db_host *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputDatabaseHost" name="database_host" value="{* var database.host *}" placeholder="{* lang db_host_info *}" />
                </div>
            </div><!--END form form-group inputDatabaseHost-->

            <div class="form-group">
                <label for="inputDatabaseUser" class="col-sm-2 control-label">{* lang db_user *}</label>
                <div class="col-sm-10">
                    <input type="text" autocomplete="off" class="form-control" id="inputDatabaseUser" name="database_user" value="{* var database.username *}" placeholder="{* lang db_user *}" />
                </div>
            </div><!--END form form-group inputDatabaseUser-->

            <div class="form-group">
                <label for="inputDatabasePassword" class="col-sm-2 control-label">{* lang password *}</label>
                <div class="col-sm-10">
                    <input type="password" autocomplete="off" class="form-control" id="inputDatabasePassword" name="database_pass" value="" placeholder="{* lang password *}" />
                </div>
            </div><!--END form form-group inputDatabasePassword-->

            <div class="form-group">
                <label for="inputDatabasePrefix" class="col-sm-2 control-label">{* lang db_prefix *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputDatabasePrefix" name="database_prefix" value="{* var database.prefix *}" placeholder="{* lang db_prefix_info *}" />
                </div>
            </div><!--END form form-group inputDatabasePrefix-->

            <div class="form-group">
                <label for="inputDatabaseSchema" class="col-sm-2 control-label">{* lang db_schema *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputDatabaseSchema" name="database_schema" value="{* var database.schema *}" placeholder="{* lang db_schema_info *}" />
                </div>
            </div><!--END form form-group inputDatabaseSchema-->

            <div class="form-group">
                <label for="inputDatabaseFile" class="col-sm-2 control-label">{* lang db_file *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputDatabaseFile" name="database_file" value="{* var database.file *}" placeholder="{* lang db_file_info *}" />
                </div>
            </div><!--END form form-group inputDatabaseFile-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang test *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->