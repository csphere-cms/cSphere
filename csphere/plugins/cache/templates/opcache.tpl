<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang cache.cache *} - {* lang cache.opcache *}
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link cache/clear *}" class="btn btn-danger">
                        {* lang cache.clear *}
                    </a>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <ul class="nav nav-tabs nav-justified">
            <li><a href="{* link cache/control *}">{* lang default.control *}</a></li>
            <li><a href="{* link cache/keys *}">{* lang cache.keys *}</a></li>
            <li class="active"><a href="{* link cache/opcache *}">{* lang cache.opcache *}</a></li>
        </ul><!--END nav-tabs-->

        <table class="table table-striped table-hover">
            <tr>
                <th>{* lang cache.op_loaded *}</th>
                <td>
                {* if extension == 'yes' *}
                {* lang default.yes *}
                {* else extension *}
                {* lang default.no *}
                {* endif extension *}
                </td>
            </tr>
            <tr>
                <th>{* lang cache.op_enable *}</th>
                <td>{* var opcache.enable *}</td>
            </tr>
            <tr>
                <th>{* lang cache.op_enable_cli *}</th>
                <td>{* var opcache.enable_cli *}</td>
            </tr>
            <tr>
                <th>{* lang cache.op_memory_con *}</th>
                <td>{* var opcache.memory_consumption *}</td>
            </tr>
            <tr>
                <th>{* lang cache.op_save_com *}</th>
                <td>{* var opcache.save_comments *}</td>
            </tr>
            <tr>
                <th>{* lang cache.op_load_com *}</th>
                <td>{* var opcache.load_comments *}</td>
            </tr>
            <tr>
                <th>{* lang cache.op_valid_time *}</th>
                <td>{* var opcache.validate_timestamps *}</td>
            </tr>
            <tr>
                <th>{* lang cache.op_revalid_freq *}</th>
                <td>{* var opcache.revalidate_freq *}</td>
            </tr>
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->