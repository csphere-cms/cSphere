<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang languages.languages *} - {* lang default.plugins *}
                    <small>
                        - {* lang languages.language *}: {* var short *}
                    </small>
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link languages/duplication/short/$short$ *}" class="btn btn-danger" role="button">
                        {* lang languages.duplication *}
                    </a>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang default.plugin *}</th>
                    <th class="text-center">{* lang languages.translated *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach plugins *}
                <tr>
                    <td>
                        {* if plugins.exists == 'yes' *}
                        <a href="{* link languages/details/short/$short$/dir/$plugins.short$ *}">
                            <i class="fa fa-fw {* var plugins.icon *}"></i>
                            &nbsp; {* var plugins.short *}
                        </a>
                        {* else plugins.exists *}
                        <i class="fa fa-fw {* var plugins.icon *}"></i>
                        &nbsp; {* var plugins.short *}
                        {* endif plugins.exists *}
                    </td>
                    <td class="text-center">
                        {* if plugins.exists == 'yes' *}
                        <i class="fa fa-fw fa-check text-success"></i>
                        {* else plugins.exists *}
                        <i class="fa fa-fw fa-times text-danger"></i>
                        {* endif plugins.exists *}
                    </td>
                </tr>
                {* endforeach plugins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->