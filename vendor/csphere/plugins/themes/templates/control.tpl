<div id="themes-control" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang themes *} - {* lang control *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang theme *}</th>
                    <th class="text-center">{* lang version *}</th>
                    <th class="text-center">{* lang published *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach themes *}
                <tr>
                    <td>
                        <a href="{* link themes/details/dir/$themes.short$ *}">
                            <i class="fa fa-fw {* var themes.icon *}"></i>
                            &nbsp; {* var themes.short *}
                        </a>
                    </td>
                    <td class="text-center">{* var themes.version *}</td>
                    <td class="text-center">{* var themes.pub *}</td>
                </tr>
                {* endforeach themes *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel panel-body-->
</div><!--END panel-->