<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=memory *}

        <br />

        {* tpl default/msg_error *}

        <form class="form-horizontal" role="form" action="{* link install/memory *}" method="POST">

            <div class="form-group">
                <label for="inputCacheDriver" class="col-sm-2 control-label">{* lang cache_type *}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="inputCacheDriver" name="cache_driver">
                    {* foreach cache.drivers *}
                    {* if drivers.active == 'yes' *}
                        <option value="{* var drivers.short *}" selected="selected">{* var drivers.name *}</option>
                    {* else drivers.active *}
                        <option value="{* var drivers.short *}">{* var drivers.name *}</option>
                    {* endif drivers.active *}
                    {* endforeach cache.drivers *}
                    </select>
                </div>
            </div><!--END form form-group inputCacheDriver-->

            <span class="help-block">{* lang cache_info *}</span>

            <div class="cache_redis">
            {* tpl default/com_input_adv name=cache_host label=default.host value=cache.host type=text holder=host_info *}

            {* tpl default/com_input_adv name=cache_port label=port value=cache.port type=text holder=port_info *}

            {* tpl default/com_input_pwd name=cache_pass label=default.password holder=default.password *}

            {* tpl default/com_input_adv name=cache_timeout label=timeout value=cache.timeout type=text holder=timeout_info *}
            </div>

            {* tpl default/com_submit_btn caption=test *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->