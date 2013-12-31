<div id="database-tables" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang database *} - {* lang tables *}
                    <small> - {* lang tables *}: {* var count *}</small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <ul class="nav nav-tabs nav-justified">
            <li><a href="{* link database/control *}">{* lang control *}</a></li>
            <li class="active"><a href="{* link database/tables *}">{* lang tables *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang plugin *}</th>
                    <th>{* lang table *}</th>
                    <th class="text-center">{* lang records *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach tables *}
                <tr>
                    <td>{* var tables.plugin *}</td>
                    <td>{* var tables.table *}</td>
                    <td class="text-center">{* var tables.records *}</td>
                </tr>
                {* endforeach tables *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel panel-body-->
</div><!--END panel-->