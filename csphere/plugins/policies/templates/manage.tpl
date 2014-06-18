<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=policies.policies action=default.manage *}

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        {* lang default.title *}
                    </th>
                    <th>
                        <a href="{* raw order.policie_date *}">{* lang default.date *}</a> {* raw arrow.policie_date *}
                    </th>
                    <th>
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach policies *}
                <tr>
                    <td>
						<a href="{* link policies/view/id/$policies.policie_id *}">
						{* if policies.policie_id == '1' *}{* lang policies.imprint *}{* endif policies.policie_id *}
						{* if policies.policie_id == '2' *}{* lang policies.terms_of_use *}{* endif policies.policie_id *}
						{* if policies.policie_id == '3' *}{* lang policies.privacy_protection *}{* endif policies.policie_id *}
						</a>
                    </td>
                    <td>
                        {* datetime policies.policie_date *}
                    </td>
                    <td>
                        <a href="{* link policies/edit/id/$policies.policie_id *}">{* lang default.edit *}</a>
                    </td>
                </tr>
                {* else policies *}
                <tr>
                    <th class="text-center" colspan="5">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach policies *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->
