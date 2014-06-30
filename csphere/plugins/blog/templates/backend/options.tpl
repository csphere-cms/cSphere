<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=blog.blog action=default.options *}

        <br>

        <form role="form" action="{* link blog/options *}" method="POST">

            {* tpl default/com_input_adv name=title_length_list label=blog.title_length_list value=options.title_length_list type=text holder=blog.title_length_list *}

            {* tpl default/com_input_adv name=title_length_manage label=blog.title_length_manage value=options.title_length_manage type=text holder=blog.title_length_manage *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
