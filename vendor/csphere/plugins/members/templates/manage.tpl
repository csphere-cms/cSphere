<div id="users-manage" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=groups action=default.manage search=group_or_user *}

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.group_name *}">{* lang group_name *}</a> {* raw arrow.group_name *}
                    </th>
                    <th>
                        <a href="{* raw order.user_name *}">{* lang user_name *}</a> {* raw arrow.user_name *}
                    </th>
                    <th colspan="2">
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach members *}
                <tr>
                    <td>
                        <a href="{* link groups/view/id/$members.group_id *}">{* var members.group_name *}</a>
                    </td>
                    <td>
                        <a href="{* link users/view/id/$members.user_id *}">{* var members.user_name *}</a>
                    </td>
                    <td>
                        <a href="{* link members/edit/id/$members.member_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link members/remove/id/$members.member_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else members *}
                <tr>
                    <th colspan="4" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach members *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->