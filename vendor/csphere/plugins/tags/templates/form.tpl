<div id="tags-form" class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang tags *} - {* if action == 'create' *}{* lang default.create *}{* else action *}{* lang default.edit *}{* endif action *}
                </h3><!--END header page-header headline-->
            </section><!--END header page-header-->
        </header><!--END header-->

        <br />

        {* if action == 'create' *}
        <form class="form-horizontal" role="form" action="{* link tags/create *}" method="POST">
        {* else action *}
        <form class="form-horizontal" role="form" action="{* link tags/edit/id/$tags.tag_id *}" method="POST">
        {* endif action *}

            <div class="form-group">
                <label for="inputTagName" class="col-sm-2 control-label">{* lang name *}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputTagName" name="tag_name" value="{* var tags.tag_name *}" placeholder="{* lang name *}" />
                </div>
            </div><!--END form form-group inputTagName-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">{* lang default.save *}</button>
                </div>
            </div><!--END form form-group submit-->

        </form><!--END form-->

    </div><!--END panel panel-body-->
</div><!--END panel-->