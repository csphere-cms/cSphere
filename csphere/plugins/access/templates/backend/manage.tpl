<div class="panel panel-default">
    <div class="panel-body">
        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang access.access *} - {* lang default.control *}
                    <small>
                        - {* lang default.count *}: {* var count *}
                    </small>
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link access/reset *}" class="btn btn-primary" role="button">
                        {* lang access.reset *}
                    </a>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang default.plugin *}</th>
                    <th class="text-center">{* lang default.version *}</th>
                    <th class="text-center">{* lang default.published *}</th>
                    <th class="text-center">{* lang default.options *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach plugins *}
                <tr>
                    <td>
                        <a href="{* link access/details/name/$plugins.short$ *}">
                            <i class="fa fa-fw {* var plugins.icon *}"></i>
                            &nbsp; {* var plugins.short *}
                        </a>
                    </td>
                    <td class="text-center">{* var plugins.version *}</td>
                    <td class="text-center">{* var plugins.pub *}</td>
                    <td class="text-center">
                        <a href="{* link access/details/name/$plugins.short$ *}">{* lang access.details *}</a>
                    </td>
                </tr>
                {* endforeach plugins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
