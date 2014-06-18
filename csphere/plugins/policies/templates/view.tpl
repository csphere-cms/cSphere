<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* if policies.policie_id == '1' *}{* lang policies.imprint *}{* endif policies.policie_id *}
                    {* if policies.policie_id == '2' *}{* lang policies.terms_of_use *}{* endif policies.policie_id *}
                    {* if policies.policie_id == '3' *}{* lang policies.privacy_protection *}{* endif policies.policie_id *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br>

        <p>{* var policies.policie_content *}</p>

        <br>

    </div><!--END panel panel-body-->

    <div class="panel-footer clearfix">
        <span class="pull-left">
            <i class="fa fa-calendar"></i> {* date policies.policie_date *}
        </span><!--END panel panel-footer date-->
    </div><!--END panel panel-footer-->

</div><!--END panel-->
