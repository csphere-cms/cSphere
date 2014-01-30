<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.welcome *}

        <br>

        {* tpl default/msg_error *}

        {* if continue == 'yes' *}
        {* lang install.welcome_info *}<br><br>
        <a href="{* link install/lang *}">{* lang default.continue *}</a>
        {* endif continue *}

        <br><br>

    </div><!--END panel-body-->
</div><!--END panel-->