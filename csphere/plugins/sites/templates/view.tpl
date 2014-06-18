{* if sites.site_layout == '1' *}
<div class="panel panel-default">
    <div class="panel-body">
        {* endif sites.site_layout *}

        <header>
            <section class="page-header">
                <h3>
                    {* var sites.site_title *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->


        <br>

        <p>{* var sites.site_content *}</p>
        {* if sites.site_layout == '1' *}

        <br>

    </div><!--END panel panel-body-->

    <div class="panel-footer">
        <i class="fa fa-tags"></i>
        {* foreach sites.site_tags *}
        {* var site_tags.tag_name *}
        {* endforeach sites.site_tags *}
    </div><!--END panel panel-footer-->

</div><!--END panel-->
{* endif sites.site_layout *}
