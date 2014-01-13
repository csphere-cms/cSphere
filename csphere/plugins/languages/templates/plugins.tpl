<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang languages *} - {* lang plugins *}
                    <small>
                        {* lang language *}: {* var short *}
                    </small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang plugin *}</th>
                    <th>{* lang translated *}</th>
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
                    <td>
                        {* if plugins.exists == 'yes' *}
                        <i class="fa fa-fw fa-check"></i>
                        {* else plugins.exists *}
                        <i class="fa fa-fw fa-times"></i>
                        {* endif plugins.exists *}
                    </td>
                </tr>
                {* endforeach plugins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->