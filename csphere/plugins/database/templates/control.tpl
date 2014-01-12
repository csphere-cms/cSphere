<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=database action=control *}

        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="{* link database/control *}">{* lang control *}</a></li>
            <li><a href="{* link database/tables *}">{* lang tables *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <tr>
                <th>{* lang driver *}</th>
                <td>{* var driver *}</td>
            </tr>
            <tr>
                <th>{* lang version_driver *}</th>
                <td>{* var version *}</td>
            </tr>
            <tr>
                <th>{* lang version_client *}</th>
                <td>{* var client *}</td>
            </tr>
            <tr>
                <th>{* lang version_server *}</th>
                <td>{* var server *}</td>
            </tr>
            <tr>
                <th>{* lang encoding *}</th>
                <td>{* var encoding *}</td>
            </tr>
            <tr>
                <th>{* lang host *}</th>
                <td>{* var host *}</td>
            </tr>
            <tr>
                <th>{* lang schema *}</th>
                <td>{* var schema *}</td>
            </tr>
            <tr>
                <th>{* lang tables *}</th>
                <td>{* var tables *}</td>
            </tr>
            <tr>
                <th>{* lang size *}</th>
                <td>{* var size *}</td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->