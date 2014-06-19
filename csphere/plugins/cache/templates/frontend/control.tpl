<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang cache.cache *} - {* lang default.control *}
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link cache/clear *}" class="btn btn-danger" role="button">
                        {* lang cache.clear *}
                    </a>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="{* link cache/control *}">{* lang default.control *}</a></li>
            <li><a href="{* link cache/keys *}">{* lang cache.keys *}</a></li>
            <li><a href="{* link cache/opcache *}">{* lang cache.opcache *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <tr>
                <th>{* lang default.driver *}</th>
                <td>{* var driver *}</td>
            </tr>
            <tr>
                <th>{* lang default.version_driver *}</th>
                <td>{* var version *}</td>
            </tr>
            <tr>
                <th>{* lang default.version_client *}</th>
                <td>{* var client *}</td>
            </tr>
            <tr>
                <th>{* lang default.version_server *}</th>
                <td>{* var server *}</td>
            </tr>
            <tr>
                <th>{* lang default.host *}</th>
                <td>{* var host *}</td>
            </tr>
            <tr>
                <th>{* lang default.port *}</th>
                <td>{* var port *}</td>
            </tr>
            <tr>
                <th>{* lang cache.keys *}</th>
                <td>{* var keys *}</td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->
