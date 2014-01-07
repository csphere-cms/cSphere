<ol class="breadcrumb">
    {* if plugin.url != '' *}
    <li><a href="{* raw plugin.url *}">{* raw plugin.text *}</a></li>
    {* else plugin.url *}
    <li>{* raw plugin.text *}</li>
    {* endif plugin.url *}
    {* foreach breadcrumb *}
    <li><a href="{* raw breadcrumb.url *}">{* raw breadcrumb.text *}</a></li>
    {* endforeach breadcrumb *}
</ol><!--END breadcrumb-->