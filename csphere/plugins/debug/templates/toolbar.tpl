<div id="csphere-debug" class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#debug-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button><!--END csphere-debug navbar-header navbar-toogle-->

            <a class="navbar-brand">cSphere</a><!--END csphere-debug navbar-header navbar-brand-->
        </div><!--END csphere-debug navbar-header-->

        <div id="debug-collapse" class="collapse navbar-collapse">

            <nav>
                <ul class="nav navbar-nav">
                    <li><a id="debug_logs_nav" onClick="csphere_debug_display('logs')">{* lang debug.logs *}: {* raw count.logs *}</a></li>
                    <li><a id="debug_database_nav" onClick="csphere_debug_display('database')">{* lang database.database *}: {* raw count.database *}</a></li>
                    <li>
                        {* if count.errors > '0' *}
                        <a id="debug_errors_nav" onClick="csphere_debug_display('errors')" class="text-danger">{* lang errors.errors *}: {* raw count.errors *}</a>
                        {* else count.errors *}
                        <a id="debug_errors_nav" onClick="csphere_debug_display('errors')">{* lang errors.errors *}: {* raw count.errors *}</a>
                        {* endif count.errors *}
                    </li>
                    <li><a id="debug_includes_nav" onClick="csphere_debug_display('includes')">{* lang debug.includes *}: {* raw count.includes *}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-debug navbar-right">
                    <li class="navbar-text">PHP {* raw php_short *}</li>
                    <li class="navbar-text">{* lang debug.parsetime *}: {* raw parsetime *} {* lang debug.ms *}</li>
                    <li class="navbar-text">{* lang debug.memory_usage *}: {* raw memory *}</li>
                </ul><!--END csphere-debug navigation navbar-nav-->
            </nav><!--END csphere-debug navigation-->

        </div><!--END csphere-debug debug-collapse-->

    </div><!--END csphere-debug container-->

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

</div><!--END csphere-debug-->