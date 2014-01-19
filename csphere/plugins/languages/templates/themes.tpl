<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang languages *} - {* lang themes.themes *}
                    <small>
                        {* lang language *}: {* var short *}
                    </small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang themes.theme *}</th>
                    <th class="text-center">{* lang translated *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach themes *}
                <tr>
                    <td>
                        {* if themes.exists == 'yes' *}
                        <a href="{* link languages/details/short/$short$/dir/$themes.short$/theme/1 *}">
                            <i class="fa fa-fw {* var themes.icon *}"></i>
                            &nbsp; {* var themes.short *}
                        </a>
                        {* else themes.exists *}
                        <i class="fa fa-fw {* var themes.icon *}"></i>
                        &nbsp; {* var themes.short *}
                        {* endif themes.exists *}
                    </td>
                    <td class="text-center">
                        {* if themes.exists == 'yes' *}
                        <i class="fa fa-fw fa-check text-success"></i>
                        {* else themes.exists *}
                        <i class="fa fa-fw fa-times text-danger"></i>
                        {* endif themes.exists *}
                    </td>
                </tr>
                {* endforeach themes *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->