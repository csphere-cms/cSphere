<div id="plugins-control" class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=plugins action=control *}

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang plugin *}</th>
                    <th class="text-center">{* lang version *}</th>
                    <th class="text-center">{* lang published *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach plugins *}
                <tr>
                    <td>
                        <a href="{* link plugins/details/dir/$plugins.short$ *}">
                            <i class="fa fa-fw {* var plugins.icon *}"></i>
                            &nbsp; {* var plugins.short *}
                        </a>
                    </td>
                    <td class="text-center">{* var plugins.version *}</td>
                    <td class="text-center">{* var plugins.pub *}</td>
                </tr>
                {* endforeach plugins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel panel-body-->
</div><!--END panel-->