<div id="default-message" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* var plugin_name *} - {* var action_name *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <div class="well text-center">
            <h4>{* var message *}</h4>

            {* if type == 'red' *}
            <br />
            <a href="{* raw previous *}" class="btn btn-danger btn-lg btn-block">{* lang default.continue *}</a>
            {* endif type *}
            {* if type == 'green' *}
            <br />
            <a href="{* raw previous *}" class="btn btn-success btn-lg btn-block">{* lang default.continue *}</a>
            {* endif type *}
            {* if type == 'default' *}
            <br />
            <a href="{* raw previous *}" class="btn btn-default btn-lg btn-block">{* lang default.continue *}</a>
            {* endif type *}
        </div><!--END well-->

    </div><!--END panel panel-body-->
</div><!--END panel-->