<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install.install action=install.memory *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/memory *}" method="POST">

            <div class="form-group">
                <label for="cache_driver" class="col-sm-2 control-label">{* lang install.cache_type *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="cache_driver" name="cache_driver">
                    {* foreach cache.drivers *}
                    {* if drivers.active == 'yes' *}
                        <option value="{* var drivers.short *}" selected="selected">{* var drivers.name *}</option>
                    {* else drivers.active *}
                        <option value="{* var drivers.short *}">{* var drivers.name *}</option>
                    {* endif drivers.active *}
                    {* endforeach cache.drivers *}
                    </select>
                </div>
            </div><!--END form form-group cache_driver-->

            <span class="help-block">{* lang install.cache_info *}</span>

            <div class="cache_redis">
            {* tpl default/com_input_adv name=cache_host label=default.host value=cache.host type=text holder=install.host_info *}

            {* tpl default/com_input_adv name=cache_port label=default.port value=cache.port type=text holder=install.port_info *}

            {* tpl default/com_input_pwd name=cache_pass label=default.password holder=default.password *}

            {* tpl default/com_input_adv name=cache_timeout label=install.timeout value=cache.timeout type=text holder=install.timeout_info *}
            </div>

            {* tpl default/com_submit_btn caption=install.test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->