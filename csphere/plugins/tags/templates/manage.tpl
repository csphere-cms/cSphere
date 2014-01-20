<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=tags action=default.manage search=name *}

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.tag_name *}">{* lang default.name *}</a> {* raw arrow.tag_name *}
                    </th>
                    <th>
                        <a href="{* raw order.tag_since *}">{* lang default.since *}</a> {* raw arrow.tag_since *}
                    </th>
                    <th colspan="2">
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach tags *}
                <tr>
                    <td>
                        <a href="{* link tags/view/id/$tags.tag_id *}">{* var tags.tag_name *}</a>
                    </td>
                    <td>
                        {* date tags.tag_since *}
                    </td>
                    <td>
                        <a href="{* link tags/edit/id/$tags.tag_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link tags/remove/id/$tags.tag_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else tags *}
                <tr>
                    <th colspan="5" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach tags *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel-body-->
</div><!--END panel-->