<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_headsearch plugin=sites.sites action=default.manage search=sites.title_or_tags *}

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.site_title *}">{* lang sites.title *}</a> {* raw arrow.site_title *}
                    </th>
                    <th>
                        <a href="{* raw order.site_publish *}">{* lang sites.published *}</a> {* raw arrow.site_publish *}
                    </th>
                    <th>
                        {* lang default.tags *}
                    </th>
                    <th colspan="2">
                        {* lang default.options *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach sites *}
                <tr>
                    <td>
                        <a href="{* link sites/view/id/$sites.site_id *}">{* var sites.site_title *}</a>
                    </td>
                    <td>
                        {* if sites.site_publish == '1' *}
                        {* lang default.yes *}
                        {* else sites.site_publish *}
                        {* lang default.no *}
                        {* endif sites.site_publish *}
                    </td>
                    <td>
                        {* var sites.site_tags *}
                    </td>
                    <td>
                        <a href="{* link sites/edit/id/$sites.site_id *}">{* lang default.edit *}</a>
                    </td>
                    <td>
                        <a href="{* link sites/remove/id/$sites.site_id *}">{* lang default.remove *}</a>
                    </td>
                </tr>
                {* else sites *}
                <tr>
                    <th class="text-center" colspan="5">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach sites *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->
