<div id="blog-form" class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=blog.blog action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=blog.blog action=default.edit *}
        {* endif action *}

        <br>

        {* if action == 'create' *}
        <form class="form-horizontal" role="form" action="{* link blog/create *}" method="POST">
        {* else action *}
        <form class="form-horizontal" role="form" action="{* link blog/edit/id/$blog.blog_id *}" method="POST">
        {* endif action *}

            {* tpl default/com_input name=blog_title label=title value=blog.blog_title *}

            {* tpl default/com_textarea name=blog_content label=content rows=5 value=blog.blog_content *}

            {* tpl default/com_input_tags name=blog_tags label=tags value=blog.blog_tags *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->