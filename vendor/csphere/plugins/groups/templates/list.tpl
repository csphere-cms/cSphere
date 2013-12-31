<div id="groups-list" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang groups *} - {* if action == 'team' *}{* lang team *}{* else action *}{* lang default.view *}{* endif action *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->

            <section class="clearfix">
                <span class="help-block pull-left">
                    {* lang default.records *}: {* var records *}{* if search != '' *} - {* lang default.hits *}: {* var hits *}{* endif search *}
                </span><!--END header help-block-->

                <div class="col-md-5 row pull-right">
                    <form class="form-inline" role="form" action="{* link groups/list *}" method="POST">
                        <div class="input-group">
                            <input type="search" class="form-control" id="inputGroupName" name="search" maxlength="40" size="20" value="{* var search *}" placeholder="{* lang name *}" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">{* lang default.search *}</button>
                            </span>
                        </div><!--END header div search input-group-->
                    </form><!--END header div search form-->
                </div><!--END header div search-->
            </section><!--END header div-->
        </header><!--END header-->

        <br />

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        <a href="{* raw order.group_name *}">{* lang name *}</a> {* raw arrow.group_name *}
                    </th>
                    <th>
                        <a href="{* raw order.group_since *}">{* lang since *}</a> {* raw arrow.group_since *}
                    </th>
                    <th>
                        {* lang url *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach groups *}
                <tr>
                    <td>
                        <a href="{* link groups/view/id/$groups.group_id *}">{* var groups.group_name *}</a>
                    </td>
                    <td>
                        {* date groups.group_since *}
                    </td>
                    <td>
                        {* if groups.group_url == '' *}
                        --
                        {* else groups.group_url *}
                        <a href="{* url groups.group_url *}">{* url groups.group_url *}</a>
                        {* endif groups.group_url *}
                    </td>
                </tr>
                {* else groups *}
                <tr>
                    <th colspan="3" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach groups *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->