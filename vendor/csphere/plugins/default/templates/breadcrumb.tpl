<ol class="breadcrumb">
    {* if plugin.url != '' *}
    <li><a href="{* raw plugin.url *}">{* var plugin.text *}</a></li>
    {* else plugin.url *}
    <li>{* var plugin.text *}</li>
    {* endif plugin.url *}
    {* foreach breadcrumb *}
    <li><a href="{* raw breadcrumb.url *}">{* var breadcrumb.text *}</a></li>
    {* endforeach breadcrumb *}
</ol><!--END breadcrumb-->