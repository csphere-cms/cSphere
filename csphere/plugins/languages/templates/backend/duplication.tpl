<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang languages.languages *} - {* lang languages.duplication *}
                    <small>
                        {* lang languages.language *}: {* var short *}
                    </small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        {* tpl default/msg_error *}

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang languages.duplication *}</th>
                    <th>{* lang default.plugins *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach duplicate *}
                <tr>
                    <th>
                        {* var duplicate.key *}
                    </th>
                    <td>
                        {* var duplicate.plugins *}
                    </td>
                </tr>
                {* else duplicate *}
                <tr>
                    <th class="text-center" colspan="2">
                        {* lang languages.no_duplicate *}
                    </th>
                </tr>
                {* endforeach duplicate *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
