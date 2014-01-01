<div id="default-message-box">

    <div class="page-header">
        <h4>{* var box_name *}</h4>
    </div><!--END users-message-box page-header-->

    <div class="well text-center">
        <h5>{* var message *}</h5>

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

</div><!--END users-message-box-->