<div class="panel panel-default panel-body">

    <header>
        <section class="page-header clearfix">
            <h3 class="pull-left">
                {* lang errors *} - {* lang file *}
                <small>
                     - {* lang date *}: {* raw date *} - {* lang count *}: {* raw count *}
                </small>
            </h3><!--END header page-header headline-->

            <div class="btn-group pull-right">
                <a href="{* link errors/remove/date/$date *}" class="btn btn-danger">
                    {* lang remove *}
                </a>
            </div><!--END header page-header btn-group-->
        </section><!--END header page-header-->
    </header><!--END header-->

    <table class="table table-striped table-hover">
        <tr>
            <th class="text-center">{* lang time *}</th>
            <th>{* lang message *}</th>
        </tr>
        {* foreach entries *}
        <tr>
            <td class="text-center">{* raw entries.time *}</td>
            <td><a href="{* link errors/details/date/$date$/entry/$entries.entry *}">{* var entries.message *}</a></td>
            </tr>
        {* endforeach entries *}
    </table><!--END table-->

</div><!--END panel-->