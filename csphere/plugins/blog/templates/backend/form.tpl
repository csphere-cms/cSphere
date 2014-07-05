<div class="panel panel-default">
    <div class="panel-body">

        {* if action == 'create' *}
        {* tpl default/com_header plugin=blog.blog action=default.create *}
        {* else action *}
        {* tpl default/com_header plugin=blog.blog action=default.edit *}
        {* endif action *}

        <br>

        {* if action == 'create' *}
        <form role="form" action="{* link blog/create *}" method="POST" enctype="multipart/form-data">
        {* else action *}
        <form role="form" action="{* link blog/edit/id/$blog.blog_id *}" method="POST" enctype="multipart/form-data">
        {* endif action *}

            {* tpl default/com_input name=blog_title label=default.title value=blog.blog_title holder=default.title *}

            {* tpl default/com_textarea name=blog_content label=blog.content rows=5 value=blog.blog_content holder=blog.content *}

            {* tpl default/com_input_tags name=blog_tags label=default.tags value=blog.blog_tags holder=default.tags *}

            {* tpl default/com_input_file name=blog_image label=blog.image *}

            {* if blog.blog_publish == '1' *}
            {* tpl default/com_input_yesno name=blog_publish label=blog.publish *}
            {* else blog.blog_publish *}
            {* tpl default/com_input_noyes name=blog_publish label=blog.publish *}
            {* endif blog.blog_publish *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->
