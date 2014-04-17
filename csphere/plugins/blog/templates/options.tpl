<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=blog.blog action=default.options *}

        <br>

        <form class="form-horizontal" role="form" action="{* link blog/options *}" method="POST">

            <div class="form-group">
                <label for="inputOutput" class="col-sm-3 control-label">{* lang blog.output *}</label>
                <div class="col-sm-9">

                    <label class="checkbox-inline">
                        {* if options.output == '0' *}
                        <input type="radio" name="output" value="0" checked="checked"> {* lang blog.output_open_first *}
                        {* else options.output *}
                        <input type="radio" name="output" value="0"> {* lang blog.output_open_first *}
                        {* endif options.output *}
                    </label>

                    <label class="checkbox-inline">
                        {* if options.output == '1' *}
                        <input type="radio" name="output" value="1" checked="checked"> {* lang blog.output_open *}
                        {* else options.output *}
                        <input type="radio" name="output" value="1"> {* lang blog.output_open *}
                        {* endif options.output *}
                    </label>

                    <label class="checkbox-inline">
                        {* if options.output == '2' *}
                        <input type="radio" name="output" value="2" checked="checked"> {* lang blog.output_closed *}
                        {* else options.output *}
                        <input type="radio" name="output" value="2"> {* lang blog.output_closed *}
                        {* endif options.output *}
                    </label>

                </div>
            </div><!--END form form-group inputOutput-->

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->