<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang errors.errors *} - {* lang default.control *}
                    <small> - {* lang default.count *}: {* raw count *}</small>
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang default.date *}</th>
                    <th>{* lang default.options *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach files *}
                <tr>
                    <td><a href="{* link errors/file/date/$files.date$ *}">{* var files.date *}</a></td>
                    <td><a href="{* link errors/remove/date/$files.date *}">{* lang default.remove *}</a></td>
                </tr>
                {* else files *}
                <tr>
                    <th colspan="2" class="text-center">
                        {* lang errors.no_file *}
                    </th>
                </tr>
                {* endforeach files *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
