<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=database.database action=default.control *}

        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="{* link database/control *}">{* lang default.control *}</a></li>
            <li><a href="{* link database/tables *}">{* lang database.tables *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <tr>
                <th>{* lang default.driver *}</th>
                <td>{* var driver *}</td>
            </tr>
            <tr>
                <th>{* lang default.version_driver *}</th>
                <td>{* var version *}</td>
            </tr>
            <tr>
                <th>{* lang default.version_client *}</th>
                <td>{* var client *}</td>
            </tr>
            <tr>
                <th>{* lang default.version_server *}</th>
                <td>{* var server *}</td>
            </tr>
            <tr>
                <th>{* lang database.encoding *}</th>
                <td>{* var encoding *}</td>
            </tr>
            <tr>
                <th>{* lang default.host *}</th>
                <td>{* var host *}</td>
            </tr>
            <tr>
                <th>{* lang database.schema *}</th>
                <td>{* var schema *}</td>
            </tr>
            <tr>
                <th>{* lang database.tables *}</th>
                <td>{* var tables *}</td>
            </tr>
            <tr>
                <th>{* lang default.size *}</th>
                <td>{* var size *}</td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
