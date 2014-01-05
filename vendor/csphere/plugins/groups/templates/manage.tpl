<div class="panel panel-default panel-body">

    {* tpl default/com_headsearch plugin=groups action=default.manage search=name *}

    <br />

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>
                    <a href="{* raw order.group_name *}">{* lang name *}</a> {* raw arrow.group_name *}
                </th>
                <th>
                    <a href="{* raw order.group_since *}">{* lang since *}</a> {* raw arrow.group_since *}
                </th>
                <th colspan="3">
                    {* lang default.options *}
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
                    <a href="{* link members/manage/search/$groups.group_name *}">{* lang members.members *}</a>
                </td>
                <td>
                    <a href="{* link groups/edit/id/$groups.group_id *}">{* lang default.edit *}</a>
                </td>
                <td>
                    <a href="{* link groups/remove/id/$groups.group_id *}">{* lang default.remove *}</a>
                </td>
            </tr>
            {* else groups *}
            <tr>
                <th colspan="5" class="text-center">
                    {* lang default.no_record_found *}
                </th>
            </tr>
            {* endforeach groups *}
        </tbody><!--END table tbody-->
    </table><!--END table-->

    {* raw pages *}

</div><!--END panel-->