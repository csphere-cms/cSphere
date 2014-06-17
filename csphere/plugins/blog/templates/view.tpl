<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* var blog.blog_title *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->


        <br>

        <p>{* var blog.blog_content *}</p>

        <br>

    </div><!--END panel panel-body-->

    <div class="panel-footer clearfix">
        <span class="pull-left">
            <i class="fa fa-calendar"></i> {* date blog.blog_date *}
        </span><!--END panel panel-footer date-->

        <span class="pull-right">
            <i class="fa fa-tags"></i>
            {* foreach blog.blog_tags *}
            <a href="{* link blog/list/search/$blog_tags.tag_name$ *}">{* var blog_tags.tag_name *}</a>
            {* endforeach blog.blog_tags *}
        </span>
    </div><!--END panel panel-footer-->

</div><!--END panel-->
