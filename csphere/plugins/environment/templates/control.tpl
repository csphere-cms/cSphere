<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=environment.environment action=default.control *}

        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="{* link environment/control *}">{* lang default.control *}</a></li>
            <li><a href="{* link environment/php *}">{* lang environment.php_details *}</a></li>
            <li><a href="{* link environment/space *}">{* lang environment.disk_space *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <tr>
                <th>{* lang environment.operating_system *}</th>
                <td>{* var operating_system *}</td>
            </tr>
            <tr>
                <th>{* lang environment.hostname *}</th>
                <td>{* var hostname *}</td>
            </tr>
            <tr>
                <th>{* lang environment.webserver *}</th>
                <td>{* var webserver *}</td>
            </tr>
            <tr>
                <th>{* lang environment.php_handler *}</th>
                <td>{* var php_handler *}</td>
            </tr>
            <tr>
                <th>{* lang environment.php_version *}</th>
                <td>{* var php_version *}</td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->