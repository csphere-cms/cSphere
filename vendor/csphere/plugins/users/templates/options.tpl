<div class="panel panel-default panel-body">

    {* tpl default/com_header plugin=users action=default.options *}

    <br />

    <form class="form-horizontal" role="form" action="{* link users/options *}" method="POST">

        <div class="form-group">
            <label for="inputForceHTTPS" class="col-sm-2 control-label">{* lang force_https *}</label>
            <div class="col-sm-10">

                <label class="checkbox-inline">
                    {* if options.force_https != '1' *}
                    <input type="radio" name="force_https" value="0" checked="checked" /> {* lang default.no *}
                    {* else options.force_https *}
                    <input type="radio" name="force_https" value="0" /> {* lang default.no *}
                    {* endif options.force_https *}
                </label>

                <label class="checkbox-inline">
                    {* if options.force_https == '1' *}
                    <input type="radio" name="force_https" value="1" checked="checked" /> {* lang default.yes *}
                    {* else options.force_https *}
                    <input type="radio" name="force_https" value="1" /> {* lang default.yes *}
                    {* endif options.force_https *}
                </label>

            </div>
        </div><!--END form form-group inputForceHTTPS-->

        {* tpl default/com_submit_btn caption=default.save *}

    </form><!--END form-->

</div><!--END panel-->