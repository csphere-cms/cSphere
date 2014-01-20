<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=users action=default.manage search=name *}

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.user_name *}">{* lang users.user_name *}</a> {* raw arrow.user_name *}
                    </th>
                    <th>
                        <a href="{* raw order.user_since *}">{* lang default.since *}</a> {* raw arrow.user_since *}
                    </th>
                    <th colspan="3">
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach users *}
                <tr>
                    <td>
                        <a href="{* link users/view/id/$users.user_id *}">{* var users.user_name *}</a>
                    </td>
                    <td>
                        {* date users.user_since *}
                    </td>
                    <td>
                        <a href="{* link members/manage/search/$users.user_name *}">{* lang members.memberships *}</a>
                    </td>
                    <td>
                        <a href="{* link users/edit/id/$users.user_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link users/remove/id/$users.user_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else users *}
                <tr>
                    <th colspan="5" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach users *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel-body-->
</div><!--END panel-->