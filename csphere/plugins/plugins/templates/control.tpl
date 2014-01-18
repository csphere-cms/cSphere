<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header clearfix">
                <h3 class="pull-left">
                    {* lang plugins *} - {* lang default.control *}
                    <small>
                        - {* lang count *}: {* var count *}
                    </small>
                </h3><!--END header page-header headline-->

                <div class="btn-group pull-right">
                    <a href="{* link plugins/market *}" class="btn btn-primary">
                        {* lang plugin_market *}
                    </a>
                    <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownOptions" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>

                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownOptions">
                        <li role="presentation"><a href="{* link plugins/market *}" role="menuitem" tabindex="-1">{* lang manual_install *}</a></li>
                    </ul>
                </div><!--END header page-header btn-group-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{* lang plugin *}</th>
                    <th class="text-center">{* lang version *}</th>
                    <th class="text-center">{* lang published *}</th>
                    <th class="text-center">{* lang options *}</th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach plugins *}
                <tr>
                    <td>
                        <a href="{* link plugins/details/dir/$plugins.short$ *}">
                            <i class="fa fa-fw {* var plugins.icon *}"></i>
                            &nbsp; {* var plugins.short *}
                        </a>
                    </td>
                    <td class="text-center">{* var plugins.version *}</td>
                    <td class="text-center">{* var plugins.pub *}</td>
                    <td class="text-center">
                        <a href="{* link plugins/delete/name/# *}">{* lang delete *}</a>
                    </td>
                </tr>
                {* endforeach plugins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

    </div><!--END panel-body-->
</div><!--END panel-->