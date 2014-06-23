<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang access.access *} - {* lang default.details *}: {* var plugin.name *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br>

        <form class="form-horizontal" role="form" action="{* link access/details/name/$plugin.name *}" method="POST" enctype="multipart/form-data">
            <div class="panel-group" id="accordion">
                {* foreach groups *}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                {* var groups.group_name *}
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            {* tpl default/com_input_yesno name=$groups.group_name[] label={var plugin.name}.permission_groupread *}
                        </div>
                    </div>
                </div>
                {* endforeach groups *}
            </div>

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->


    </div><!--END panel-body-->
</div><!--END panel-->
