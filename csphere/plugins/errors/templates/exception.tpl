<div class="well">
    <dl class="dl-horizontal">
        <dt>{* lang errors.message *}:</dt>
        <dd class="word-break">{* var error.message *}</dd>
        <dt>{* lang errors.code *}:</dt>
        <dd>{* var error.code *}</dd>
        <dt>{* lang errors.file *}:</dt>
        <dd class="word-break">{* var error.file *}</dd>
        <dt>{* lang errors.line *}:</dt>
        <dd>{* var error.line *}</dd>
    </dl><!--END well list-->
</div><!--END well-->

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th class="text-center">
                {* lang errors.step *}
            </th>
            <th>
                {* lang errors.file *}
            </th>
            <th class="text-center">
                {* lang errors.line *}
            </th>
            <th>
                {* lang errors.call *}
            </th>
        </tr>
    </thead><!--END table thead-->

    <tbody>
        {* foreach trace *}
        <tr>
            <td class="text-center">
                {* var trace.step *}
            </td>
            <td class="word-break">
                {* var trace.file *}
            </td>
            <td class="text-center">
                {* var trace.line *}
            </td>
            <td class="word-break">
                {* var trace.call *}
            </td>
        </tr>
        {* endforeach trace *}
    </tbody><!--END table tbody-->
</table><!--END table-->
