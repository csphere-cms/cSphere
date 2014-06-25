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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{* var groups.group_name *}">
                                {* var groups.group_name *}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse_{* var groups.group_name *}" class="panel-collapse collapse in">
                        <div class="panel-body">
                            {* foreach groups.permissions *}
                                {* if permissions.permission_value == '1' *}
                                    {* tpl access/input_yesno group=groups.group_name permission=permissions.permission_title label=permissions.permission_label *}
                                {* else permissions.permission_value *}
                                    {* tpl access/input_noyes group=groups.group_name permission=permissions.permission_title label=permissions.permission_label *}
                                {* endif permissions.permission_value *}
                            {* endforeach groups.permissions *}
                        </div>
                    </div>
                </div>
                {* endforeach groups *}
            </div>
            {* tpl default/com_submit_btn caption=default.save *}
        </form><!--END form-->
    </div><!--END panel-body-->
</div><!--END panel-->
