<div id="debug-navigation" class="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#debug-collapse">
                <i class="fa fa-bars"></i>
            </button><!--END debug-navigation navbar-header navbar-toogle-->

            <a class="navbar-brand">cSphere</a><!--END debug-navigation navbar-header navbar-brand-->
        </div><!--END debug-navigation navbar-header-->

        <div id="debug-collapse" class="collapse navbar-collapse">

            <nav>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a id="debug_logs_nav" onClick="csphere_debug_display('logs')" class="popover-nav" data-content="{* lang debug.logs *}">
                            <i class="fa fa-list-alt fa-lg"></i>
                            {* raw count.logs *}
                        </a>
                    </li>
                    <li>
                        <a id="debug_database_nav" onClick="csphere_debug_display('database')" class="popover-nav" data-content="{* lang database.database *}">
                            <i class="fa fa-archive fa-lg"></i>
                            {* raw count.database *}
                        </a>
                    </li>
                    <li>
                        {* if count.errors > '0' *}
                        <a id="debug_errors_nav" onClick="csphere_debug_display('errors')" class="popover-nav text-danger" data-content="{* lang errors.errors *}">
                            <i class="fa fa-exclamation-triangle fa-lg"></i>
                            {* raw count.errors *}
                        </a>
                        {* else count.errors *}
                        <a id="debug_errors_nav" onClick="csphere_debug_display('errors')" class="popover-nav" data-content="{* lang errors.errors *}">
                            <i class="fa fa-exclamation-triangle fa-lg"></i>
                            {* raw count.errors *}
                        </a>
                        {* endif count.errors *}
                    </li>
                    <li>
                        <a id="debug_includes_nav" onClick="csphere_debug_display('includes')" class="popover-nav" data-content="{* lang debug.includes *}">
                            <i class="fa fa-files-o fa-lg"></i>
                            {* raw count.includes *}
                        </a>
                    </li>
                </ul>
            </nav><!--END debug-navigation navigation-->

            <ul class="nav navbar-nav navbar-right">
               <li>
                    <a class="popover-nav" data-content="PHP {* raw php_full *}">
                        PHP {* raw php_short *}
                    </a>
                <li>
                <li>
                    <a id="debug_request_selector" class="popover-nav" data-content="{* lang debug.request_type *}">
                        <i class="fa fa-refresh fa-lg"></i>
                        <strong id="debug_request_type">HTTP</strong>
                    </a>
                </li>
                <li>
                    <a class="popover-nav" data-content="{* lang debug.parsetime *}">
                        <i class="fa fa-clock-o fa-lg"></i>
                        {* raw parsetime *} {* lang debug.ms *}
                    </a>
                <li>
                    <a class="popover-nav" data-content="{* lang debug.memory_usage *}">
                        <i class="fa fa-hdd-o fa-lg"></i>
                        {* raw memory *}
                    </a>
                </li>
            </ul><!--END debug-navigation navigation navbar-nav-->

        </div><!--END debug-navigation debug-collapse-->

    </div><!--END debug-navigation container-->
</div><!--END debug-navigation-->


<div id="debug-content" class="navbar navbar-default navbar-fixed-bottom">

        <section id="debug_logs" class="debug_content container">
        {* lang debug.logs *}:

        {* foreach logbar *}
         | <a id="debug_logs-{* raw logbar.component *}_nav" onClick="csphere_debug_display('logs-{* raw logbar.component *}')">
        {* raw logbar.component *} ({* raw logbar.count *})
        </a>
        {* endforeach logbar *}
    </section><!--END csphere-debug debug_logs-->

    {* foreach logs *}
    <section id="debug_logs-{* raw logs.name *}" class="debug_content container">
        {* lang debug.component *} "{* raw logs.name *}":
        <br /><br />
        <ol>
            {* foreach logs.entries *}
            <li>{* var entries.text *}</li>
            {* endforeach logs.entries *}
        </ol>
    </section><!--END csphere-debug debug_logs-->
    {* endforeach logs *}

    <section id="debug_database" class="debug_content container">
        {* lang database.database *}:
        <br /><br />
        <ol>
            {* foreach database *}
            <li>{* var database.text *}</li>
            {* endforeach database *}
        </ol>
    </section><!--END csphere-debug debug_database-->

    <section id="debug_errors" class="debug_content container">
        {* lang errors.errors *}:
        <br /><br />
        <ol>
            {* foreach errors *}
            <li>{* var errors.text *}</li>
            {* endforeach errors *}
        </ol>
    </section><!--END csphere-debug debug_errors-->

    <section id="debug_includes" class="debug_content container">
        {* lang debug.includes *}:
        <br /><br />
        <ol>
            {* foreach includes *}
            <li>{* raw includes.text *}</li>
            {* endforeach includes *}
        </ol>
    </section><!--END csphere-debug debug_includes-->

</div><!--END debug-content-->