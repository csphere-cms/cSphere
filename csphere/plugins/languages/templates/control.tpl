<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=languages action=default.control *}

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang short *}</th>
                    <th class="text-center">{* lang language *}</th>
                    <th class="text-center" colspan="2">{* lang default.details *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach languages *}
                <tr>
                    <td>
                        <img src="{* raw languages.icon_url *}" alt="{* var languages.icon *}" />
                        &nbsp; {* var languages.short *}
                    </td>
                    <td class="text-center">{* var languages.name *}</td>
                    <td class="text-center">
                        <a href="{* link languages/plugins/short/$languages.short$ *}">{* lang plugins.plugins *}</a>
                    </td>
                    <td class="text-center">
                        <a href="{* link languages/themes/short/$languages.short$ *}">{* lang themes.themes *}</a>
                    </td>
                </tr>
                {* endforeach languages *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->