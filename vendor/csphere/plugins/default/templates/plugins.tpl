<div class="row grid-list">
    {* foreach plugins *}
    <div class="col-md-3">
        <a href="{* link $plugins.dir$/$action$ *}">
            <i class="fa fa-3x {* var plugins.icon *}"></i>
            {* var plugins.name *}
        </a>
    </div><!--END row col-md-3-->
    {* endforeach plugins *}
</div><!--END row-->