<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=faq.faq action=default.options *}

        <br>

        <form class="form-horizontal" role="form" action="{* link faq/options *}" method="POST">

            <div class="form-group">
                <label for="inputOutput" class="col-sm-3 control-label">{* lang faq.output *}</label>
                <div class="col-sm-9">

                    <label class="checkbox-inline">
                        {* if options.output == '0' *}
                        <input type="radio" name="output" value="0" checked="checked"> {* lang faq.output_open_first *}
                        {* else options.output *}
                        <input type="radio" name="output" value="0"> {* lang faq.output_open_first *}
                        {* endif options.output *}
                    </label>

                    <label class="checkbox-inline">
                        {* if options.output == '1' *}
                        <input type="radio" name="output" value="1" checked="checked"> {* lang faq.output_open *}
                        {* else options.output *}
                        <input type="radio" name="output" value="1"> {* lang faq.output_open *}
                        {* endif options.output *}
                    </label>

                    <label class="checkbox-inline">
                        {* if options.output == '2' *}
                        <input type="radio" name="output" value="2" checked="checked"> {* lang faq.output_closed *}
                        {* else options.output *}
                        <input type="radio" name="output" value="2"> {* lang faq.output_closed *}
                        {* endif options.output *}
                    </label>

                </div>
            </div><!--END form form-group inputOutput-->

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->
