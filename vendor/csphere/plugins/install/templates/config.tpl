<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=install action=config *}

        <br />

        {* if error != '' *}
        <div class="alert alert-danger text-center">
            <strong>{* var error *}</strong>
        </div>

        <br />
        {* endif error *}

        <form class="form-horizontal" role="form" action="{* link install/config *}" method="POST">

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

            {* if config.logs == '1' *}
            {* tpl default/com_input_yesno name=logs label=error_logs *}
            {* else config.logs *}
            {* tpl default/com_input_noyes name=logs label=error_logs *}
            {* endif config.logs *}

            <span class="help-block">{* lang logs_info *}</span>

            {* if config.zlib == '1' *}
            {* tpl default/com_input_yesno name=zlib label=zlib_compression *}
            {* else config.zlib *}
            {* tpl default/com_input_noyes name=zlib label=zlib_compression *}
            {* endif config.zlib *}

            <span class="help-block">{* lang zlib_info *}</span>

            {* if config.debug == '1' *}
            {* tpl default/com_input_yesno name=debug label=debug_mode *}
            {* else config.debug *}
            {* tpl default/com_input_noyes name=debug label=debug_mode *}
            {* endif config.debug *}

            <span class="help-block">{* lang debug_info *}</span>

            {* if config.rewrite == '1' *}
            {* tpl default/com_input_yesno name=rewrite label=pretty_urls *}
            {* else config.rewrite *}
            {* tpl default/com_input_noyes name=rewrite label=pretty_urls *}
            {* endif config.rewrite *}

            <span class="help-block">{* lang rewrite_info *}</span>

            {* if config.ajax == '1' *}
            {* tpl default/com_input_yesno name=ajax label=ajax_full *}
            {* else config.ajax *}
            {* tpl default/com_input_noyes name=ajax label=ajax_full *}
            {* endif config.ajax *}

            <span class="help-block">{* lang ajax_info *}</span>

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->