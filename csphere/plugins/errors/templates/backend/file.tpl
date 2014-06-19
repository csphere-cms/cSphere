<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang errors.errors *} - {* lang errors.file *}
                    <small>
                         - {* lang default.date *}: {* raw date *} - {* lang default.count *}: {* raw count *}
                    </small>
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link errors/remove/date/$date *}" class="btn btn-danger">
                        {* lang default.remove *}
                    </a>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <tr>
                <th class="text-center">{* lang default.time *}</th>
                <th>{* lang errors.message *}</th>
            </tr>
            {* foreach entries *}
            <tr>
                <td class="text-center">{* raw entries.time *}</td>
                <td><a href="{* link errors/details/date/$date$/entry/$entries.entry *}">{* var entries.message *}</a></td>
                </tr>
            {* endforeach entries *}
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
