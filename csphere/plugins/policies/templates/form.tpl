<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* if policies.policie_id == '1' *}{* lang policies.imprint *}{* endif policies.policie_id *}
                    {* if policies.policie_id == '2' *}{* lang policies.terms_of_use *}{* endif policies.policie_id *}
                    {* if policies.policie_id == '3' *}{* lang policies.privacy_protection *}{* endif policies.policie_id *} - {* lang default.edit *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br>

        <form class="form-horizontal" role="form" action="{* link policies/edit/id/$policies.policie_id *}" method="POST">

            {* tpl default/com_textarea name=policie_content label=policies.content rows=5 value=policies.policie_content *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->
