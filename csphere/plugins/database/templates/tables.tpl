<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang database *} - {* lang tables *}
                    <small> - {* lang tables *}: {* var count *}</small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        {* if error != '' *}
        <div class="alert alert-danger text-center">
            <strong>{* var error *}</strong>
        </div>

        <br />
        {* endif error *}

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
                    <td>
                        <a href="{* link database/details/dir/$tables.plugin$ *}">{* raw tables.plugin *}</a>
                    </td>
                    <td>{* var tables.table *}</td>
                    <td class="text-center">{* var tables.records *}</td>
                </tr>
                {* endforeach tables *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->