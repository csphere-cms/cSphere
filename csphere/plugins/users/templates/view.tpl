<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users.users action=default.view *}

        <table class="table table-striped table-hover">
            <tr>
                <th>
                    {* lang users.user_name *}
                </th>
                <td>
                    {* var users.user_name *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang default.since *}
                </th>
                <td>
                    {* date users.user_since *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang users.laston *}
                </th>
                <td>
                    {* date users.user_laston *}
                </td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
