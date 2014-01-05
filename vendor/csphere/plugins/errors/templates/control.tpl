<div class="panel panel-default panel-body">

    <header>
        <section class="page-header">
            <h3>
                {* lang errors *} - {* lang control *}
                <small> - {* lang count *}: {* raw count *}</small>
            </h3><!--END header page-header headline-->
        </section><!--END header page-header-->
    </header><!--END header-->

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>{* lang date *}</th>
                <th>{* lang default.options *}</th>
            </tr>
        </thead><!--END table thead-->

        <tbody>
            {* foreach files *}
            <tr>
                <td><a href="{* link errors/file/date/$files.date$ *}">{* var files.date *}</a></td>
                <td><a href="{* link errors/remove/date/$files.date *}">{* lang remove *}</a></td>
            </tr>
            {* else files *}
            <tr>
                <th colspan="2" class="text-center">{* lang no_file *}</td>
            </tr>
            {* endforeach files *}
        </tbody><!--END table tbody-->
    </table><!--END table-->

</div><!--END panel-->