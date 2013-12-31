<div id="users-list" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang users *} - {* lang visits *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->

            <section class="clearfix">
                <span class="help-block pull-left">
                    {* lang default.records *}: {* var records *}{* if search != '' *} - {* lang default.hits *}: {* var hits *}{* endif search *}
                </span><!--END header help-block-->

                <div class="col-md-5 row pull-right">
                    <form class="form-inline" role="form" action="{* link users/visits *}" method="POST">
                        <div class="input-group">
                            <input type="search" class="form-control" id="inputBrowserName" name="search" maxlength="40" size="20" value="{* var search *}" placeholder="{* lang login_browser *}" />
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
                        <a href="{* raw order.login_since *}">{* lang login_since *}</a> {* raw arrow.login_since *}
                    </th>
                    <th>
                        <a href="{* raw order.login_browser *}">{* lang login_browser *}</a> {* raw arrow.login_browser *}
                    </th>
                </tr>
            </thead><!--END table thead-->

            <tbody>
                {* foreach users_logins *}
                <tr>
                    <td>
                        {* date users_logins.login_since *}
                    </td>
                    <td>
                        <span title="{* var users_logins.login_browser *}">{* var users_logins.scan_browser *}</span>
                    </td>
                </tr>
                {* else users_logins *}
                <tr>
                    <th colspan="3" class="text-center">
                        {* lang default.no_record_found *}
                    </th>
                </tr>
                {* endforeach users_logins *}
            </tbody><!--END table tbody-->
        </table><!--END table-->

        {* raw pages *}

    </div><!--END panel panel-body-->
</div><!--END panel-->