<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang cache.cache *} - {* lang cache.keys *}
                    <small>
                        - {* lang cache.keys *}: {* raw count *}
                    </small>
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link cache/clear *}" class="btn btn-danger" role="button">
                        {* lang cache.clear *}
                    </a>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <ul class="nav nav-tabs nav-justified">
            <li><a href="{* link cache/control *}">{* lang default.control *}</a></li>
            <li class="active"><a href="{* link cache/keys *}">{* lang cache.keys *}</a></li>
            <li><a href="{* link cache/opcache *}">{* lang cache.opcache *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang cache.key *}</th>
                    <th>{* lang default.time *}</th>
                    <th class="text-center">{* lang default.size *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach entries *}
                <tr>
                    <td>{* var entries.name *}</td>
                    <td>{* date entries.time *}</td>
                    <td class="text-center">{* var entries.size *}</td>
                </tr>
                {* else entries *}
                <tr>
                    <th colspan="3" class="text-center">
                        {* lang cache.no_entry *}
                    </th>
                </tr>
                {* endforeach entries *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->