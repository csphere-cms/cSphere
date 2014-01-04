<header>
    <section class="page-header clearfix">
        <h3 class="pull-left">
            {* com lang plugin *} - {* com lang action *}
        </h3><!--END header page-header headline-->

        {* if buttons.create == 'yes' *}
        <div class="btn-group pull-right">
            <a href="{* link $plugin$/create *}" class="btn btn-primary">{* lang default.create *}</a>

            {* if buttons.options == 'yes' *}
            <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownOptions" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>

            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownOptions">
                <li role="presentation"><a href="{* link $plugin$/options *}" role="menuitem" tabindex="-1">{* lang default.options *}</a></li>
            </ul>
            {* endif buttons.options *}

        </div><!--END header page-header btn-group-->
        {* endif buttons.create *}

    </section><!--END header page-header-->

    <section class="clearfix">
        <span class="help-block pull-left">
            {* lang default.records *}: {* var records *}{* if search != '' *} - {* lang default.hits *}: {* var hits *}{* endif search *}
        </span><!--END header help-block-->

        <div class="col-md-5 row pull-right">
            <form class="form-inline" role="form" action="{* link $plugin$/manage *}" method="POST">
                <div class="input-group">
                    <input type="search" class="form-control" name="search" maxlength="80" size="20" value="{* var search *}" placeholder="{* com lang search *}" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">{* lang default.search *}</button>
                    </span>
                </div><!--END header div search input-group-->
            </form><!--END header div search form-->
        </div><!--END header div search-->
    </section><!--END header div-->
</header><!--END header-->