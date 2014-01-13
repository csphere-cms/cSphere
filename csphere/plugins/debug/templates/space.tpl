<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=debug action=disk_space *}

        <ul class="nav nav-tabs nav-justified">
            <li><a href="{* link debug/control *}">{* lang default.control *}</a></li>
            <li><a href="{* link debug/php *}">{* lang php_details *}</a></li>
            <li class="active"><a href="{* link debug/space *}">{* lang disk_space *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <tr>
                <th>{* lang space_total *}</th>
                <td class="text-center">{* var total *}</td>
                <td class="text-center">{* var total_percent *}</td>
            </tr>
            <tr>
                <th>{* lang space_used *}</th>
                <td class="text-center">{* var used *}</td>
                <td class="text-center">{* var used_percent *}</td>
            </tr>
            <tr>
                <th>{* lang space_free *}</th>
                <td class="text-center">{* var free *}</td>
                <td class="text-center">{* var free_percent *}</td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->