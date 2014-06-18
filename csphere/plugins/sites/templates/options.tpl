<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=sites.sites action=default.options *}

        <br>

        <form class="form-horizontal" role="form" action="{* link sites/options *}" method="POST">

            {* tpl default/com_input_adv name=title_length_list label=sites.title_length_list value=options.title_length_list type=text holder=sites.title_length_list *}

            {* tpl default/com_input_adv name=title_length_manage label=sites.title_length_manage value=options.title_length_manage type=text holder=sites.title_length_manage *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
