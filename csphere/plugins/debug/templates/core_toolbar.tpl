<div id="debug-navigation" class="navbar navbar-default navbar-fixed-bottom hidden-xs" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#debug-collapse">
                <i class="fa fa-bars"></i>
            </button><!--END debug-navigation navbar-header navbar-toogle-->

            <a class="navbar-brand" data-content="cSphere"></a><!--END debug-navigation navbar-header navbar-brand-->
        </div><!--END debug-navigation navbar-header-->

        <div id="debug-collapse" class="collapse navbar-collapse">

            <nav>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#tab-logs" class="csphere-popover" data-toggle="tab" data-content="{* lang debug.logs *}">
                            <i class="fa fa-list-alt fa-lg"></i>
                            {* raw count.logs *}
                        </a>
                    </li>
                    <li>
                        <a href="#tab-database" class="csphere-popover" data-toggle="tab" data-content="{* lang database.database *}">
                            <i class="fa fa-archive fa-lg"></i>
                            {* raw count.database *}
                        </a>
                    </li>
                    <li>
                        {* if count.errors > '0' *}
                        <a href="#tab-errors" class="csphere-popover text-danger" data-toggle="tab" data-content="{* lang errors.errors *}">
                            <i class="fa fa-exclamation-triangle fa-lg"></i>
                            {* raw count.errors *}
                        </a>
                        {* else count.errors *}
                        <a href="#tab-errors" class="csphere-popover" data-toggle="tab" data-content="{* lang errors.errors *}">
                            <i class="fa fa-exclamation-triangle fa-lg"></i>
                            {* raw count.errors *}
                        </a>
                        {* endif count.errors *}
                    </li>
                    <li>
                        <a href="#tab-includes" class="csphere-popover" data-toggle="tab" data-content="{* lang debug.includes *}">
                            <i class="fa fa-files-o fa-lg"></i>
                            {* raw count.includes *}
                        </a>
                    </li>
                    <li class="active">
                        <a href="#tab-empty" class="csphere-popover" data-toggle="tab" data-content="{* lang debug.close_toolbar *}">
                            <i class="fa fa-times"></i>
                        </a>
                    </li>
                </ul>
            </nav><!--END debug-navigation navigation-->

            <ul class="nav navbar-nav navbar-right">
               <li>
                    <a class="csphere-popover" data-content="{* raw php_full *}">
                        <i class="fa fa-usd fa-lg"></i>
                        {* raw php_engine *}
                    </a>
                <li>
                <li>
                    <a id="debug_request_selector" class="csphere-popover" data-content="{* lang debug.request_type *}">
                        <i class="fa fa-refresh fa-lg"></i>
                        <strong id="debug_request_type">HTTP</strong>
                    </a>
                </li>
                <li>
                    <a class="csphere-popover" data-content="{* lang debug.parsetime *}">
                        <i class="fa fa-clock-o fa-lg"></i>
                        {* raw parsetime *} {* lang debug.ms *}
                    </a>
                <li>
                    <a class="csphere-popover" data-content="{* lang debug.memory_usage *}">
                        <i class="fa fa-hdd-o fa-lg"></i>
                        {* raw memory *}
                    </a>
                </li>
            </ul><!--END debug-navigation navigation navbar-nav-->

        </div><!--END debug-navigation debug-collapse-->

    </div><!--END debug-navigation container-->
</div><!--END debug-navigation-->


<div id="debug-content" class="navbar navbar-default navbar-fixed-bottom hidden-xs">
    <div class="container tab-content">

        <section id="tab-empty" class="tab-pane fade in active">
        </section><!--END debug-content empty tab-->

        <section id="tab-logs" class="tab-pane fade">

            <header class="page-header">
                <h3>{* lang debug.logs *}</h3>
            </header><!--END debug-content tab-logs header-->

            <div class="row">
                <aside class="col-md-2">
                    <ul class="nav nav-pills nav-stacked">
                        {* foreach logbar *}
                        <li class="active">
                            <a href="#logs-{* raw logbar.component *}" data-toggle="tab">
                                {* raw logbar.component *}
                                <span class="badge pull-right">{* raw logbar.count *}</span>
                            </a>
                        </li>
                        {* endforeach logbar *}
                    </ul>
                </aside><!--END debug-content tab-logs row col-md-2-->

                <div class="col-md-10 tab-content">
                    {* foreach logs *}
                    <div class="tab-pane fade in active" id="logs-{* raw logs.name *}">
                            <ol>
                                {* foreach logs.entries *}
                                <li>{* var entries.text *}</li>
                                {* endforeach logs.entries *}
                            </ol>
                    </div>
                    {* endforeach logs *}
                </div><!--END debug-content tab-logs row col-md-10-->
            </div><!--END debug-content tab-logs row-->

        </section><!--END debug-content tab-logs-->

        <section id="tab-database" class="tab-pane fade">

            <header class="page-header">
                <h3>{* lang database.database *}</h3>
            </header><!--END debug-content tab-database header-->

            <ol>
                {* foreach database *}
                <li>{* var database.text *}</li>
                {* endforeach database *}
            </ol>
        </section><!--END debug-content tab-database-->

        <section id="tab-errors" class="tab-pane fade">

            <header class="page-header">
                <h3>{* lang errors.errors *}</h3>
            </header><!--END debug-content tab-errors header-->

            <ol>
                {* foreach errors *}
                <li>{* var errors.text *}</li>
                {* endforeach errors *}
            </ol>
        </section><!--END debug-content tab-errors-->

        <section id="tab-includes" class="tab-pane fade">

            <header class="page-header">
                <h3>{* lang debug.includes *}</h3>
            </header><!--END debug-content tab-includes header-->

            <ol>
                {* foreach includes *}
                <li>{* raw includes.text *}</li>
                {* endforeach includes *}
            </ol>
        </section><!--END debug-content tab-includes-->

    </div><!--END debug-content container-->
</div><!--END debug-content-->