<ol class="breadcrumb">
    {* if plugin.url != '' *}
    <li><a href="{* raw plugin.url *}">{* raw plugin.lang *}</a></li>
    {* else plugin.url *}
    <li>{* raw plugin.lang *}</li>
    {* endif plugin.url *}
    {* foreach breadcrumb *}
    <li><a href="{* raw breadcrumb.url *}">{* raw breadcrumb.lang *}</a></li>
    {* endforeach breadcrumb *}
</ol><!--END breadcrumb-->