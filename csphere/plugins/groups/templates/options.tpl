<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=groups action=default.options *}

        <br />

        <form class="form-horizontal" role="form" action="{* link groups/options *}" method="POST">

            {* tpl default/com_input_adv name=main_name label=main_id value=options.main_name type=text holder=main_name *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->