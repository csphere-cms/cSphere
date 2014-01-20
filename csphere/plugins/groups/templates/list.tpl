<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=groups action=default.list search=default.name *}

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.group_name *}">{* lang users.user_name *}</a> {* raw arrow.group_name *}
                    </th>
                    <th>
                        <a href="{* raw order.group_since *}">{* lang default.since *}</a> {* raw arrow.group_since *}
                    </th>
                    <th>
                        {* lang url *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach groups *}
                <tr>
                    <td>
                        <a href="{* link groups/view/id/$groups.group_id *}">{* var groups.group_name *}</a>
                    </td>
                    <td>
                        {* date groups.group_since *}
                    </td>
                    <td>
                        {* if groups.group_url == '' *}
                        --
                        {* else groups.group_url *}
                        <a href="{* var groups.group_url *}">{* var groups.group_url *}</a>
                        {* endif groups.group_url *}
                    </td>
                </tr>
                {* else groups *}
                <tr>
                    <th colspan="3" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach groups *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel-body-->
</div><!--END panel-->