<div id="install-config" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang install *} - {* lang config *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

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
                    <br />
                    {* lang cache_info *}
                </div>
            </div><!--END form form-group inputCacheDriver-->

            <div class="form-group">
                <label for="inputLogs" class="col-sm-2 control-label">{* lang error_logs *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if config.logs != '1' *}
                        <input type="radio" name="logs" value="0" checked="checked" /> {* lang default.no *}
                        {* else config.logs *}
                        <input type="radio" name="logs" value="0" /> {* lang default.no *}
                        {* endif config.logs *}
                    </label>

                    <label class="checkbox-inline">
                        {* if config.logs == '1' *}
                        <input type="radio" name="logs" value="1" checked="checked" /> {* lang default.yes *}
                        {* else config.logs *}
                        <input type="radio" name="logs" value="1" /> {* lang default.yes *}
                        {* endif config.logs *}
                    </label>
                    <br />
                    {* lang logs_info *}
                </div>
            </div><!--END form form-group inputLogs-->

            <div class="form-group">
                <label for="inputZlib" class="col-sm-2 control-label">{* lang zlib_compression *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if config.zlib != '1' *}
                        <input type="radio" name="zlib" value="0" checked="checked" /> {* lang default.no *}
                        {* else config.zlib *}
                        <input type="radio" name="zlib" value="0" /> {* lang default.no *}
                        {* endif config.zlib *}
                    </label>

                    <label class="checkbox-inline">
                        {* if config.zlib == '1' *}
                        <input type="radio" name="zlib" value="1" checked="checked" /> {* lang default.yes *}
                        {* else config.zlib *}
                        <input type="radio" name="zlib" value="1" /> {* lang default.yes *}
                        {* endif config.zlib *}
                    </label>
                    <br />
                    {* lang zlib_info *}
                </div>
            </div><!--END form form-group inputZlib-->

            <div class="form-group">
                <label for="inputDebug" class="col-sm-2 control-label">{* lang debug_mode *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if config.debug != '1' *}
                        <input type="radio" name="debug" value="0" checked="checked" /> {* lang default.no *}
                        {* else config.debug *}
                        <input type="radio" name="debug" value="0" /> {* lang default.no *}
                        {* endif config.debug *}
                    </label>

                    <label class="checkbox-inline">
                        {* if config.debug == '1' *}
                        <input type="radio" name="debug" value="1" checked="checked" /> {* lang default.yes *}
                        {* else config.debug *}
                        <input type="radio" name="debug" value="1" /> {* lang default.yes *}
                        {* endif config.debug *}
                    </label>
                    <br />
                    {* lang debug_info *}
                </div>
            </div><!--END form form-group inputDebug-->

            <div class="form-group">
                <label for="inputRewrite" class="col-sm-2 control-label">{* lang pretty_urls *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if config.rewrite != '1' *}
                        <input type="radio" name="rewrite" value="0" checked="checked" /> {* lang default.no *}
                        {* else config.rewrite *}
                        <input type="radio" name="rewrite" value="0" /> {* lang default.no *}
                        {* endif config.rewrite *}
                    </label>

                    <label class="checkbox-inline">
                        {* if config.rewrite == '1' *}
                        <input type="radio" name="rewrite" value="1" checked="checked" /> {* lang default.yes *}
                        {* else config.rewrite *}
                        <input type="radio" name="rewrite" value="1" /> {* lang default.yes *}
                        {* endif config.rewrite *}
                    </label>
                    <br />
                    {* lang rewrite_info *}
                </div>
            </div><!--END form form-group inputRewrite-->

            <div class="form-group">
                <label for="inputAJAX" class="col-sm-2 control-label">{* lang ajax_full *}</label>
                <div class="col-sm-10">

                    <label class="checkbox-inline">
                        {* if config.ajax != '1' *}
                        <input type="radio" name="ajax" value="0" checked="checked" /> {* lang default.no *}
                        {* else config.ajax *}
                        <input type="radio" name="ajax" value="0" /> {* lang default.no *}
                        {* endif config.ajax *}
                    </label>

                    <label class="checkbox-inline">
                        {* if config.ajax == '1' *}
                        <input type="radio" name="ajax" value="1" checked="checked" /> {* lang default.yes *}
                        {* else config.ajax *}
                        <input type="radio" name="ajax" value="1" /> {* lang default.yes *}
                        {* endif config.ajax *}
                    </label>
                    <br />
                    {* lang ajax_info *}
                </div>
            </div><!--END form form-group inputAJAX-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->