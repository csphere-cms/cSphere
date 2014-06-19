<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=users.users action=default.options *}

        <br>

        <form class="form-horizontal" role="form" action="{* link users/options *}" method="POST">

            {* if options.force_https == '1' *}
            {* tpl default/com_input_yesno name=force_https label=users.force_https *}
            {* else options.force_https *}
            {* tpl default/com_input_noyes name=force_https label=users.force_https *}
            {* endif options.force_https *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
