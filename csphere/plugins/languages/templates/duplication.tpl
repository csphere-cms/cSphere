<div class="panel panel-default">
    <div class="panel-body">

        <header>
            <section class="page-header">
                <h3>
                    {* lang languages *} - {* lang duplication *}
                    <small>
                        {* lang language *}: {* var short *}
                    </small>
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

        <dl class="dl-horizontal">

            {* foreach duplicate *}
            <dt>{* var duplicate.key *}:</dt>
            <dd>{* var duplicate.plugins *}</dd>
            {* endforeach duplicate *}
        </dl>

        <br /><br />

    </div><!--END panel-body-->
</div><!--END panel-->