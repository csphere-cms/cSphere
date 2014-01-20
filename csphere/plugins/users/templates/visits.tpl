<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=users.users action=users.visits search=users.login_browser *}

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.login_since *}">{* lang users.login_since *}</a> {* raw arrow.login_since *}
                    </th>
                    <th>
                        <a href="{* raw order.login_browser *}">{* lang users.login_browser *}</a> {* raw arrow.login_browser *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach users_logins *}
                <tr>
                    <td>
                        {* date users_logins.login_since *}
                    </td>
                    <td>
                        <span title="{* var users_logins.login_browser *}">{* var users_logins.scan_browser *}</span>
                    </td>
                </tr>
                {* else users_logins *}
                <tr>
                    <th colspan="3" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach users_logins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel-body-->
</div><!--END panel-->