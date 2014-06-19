<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=contact.contact action=default.view *}

        <br>

        <table class="table table-striped table-hover">
            <tr>
                <th>
                    {* lang default.name *}
                </th>
                <td>
                    {* var contact.contact_name *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang default.date *}
                </th>
                <td>
                    {* date contact.contact_date *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang default.contact_email *}
                </th>
                <td>
                    {* var contact.contact_mail *}
                </td>
            </tr>
            <tr>
                <th>
                    {* lang contact.message *}
                </th>
                <td>
                    {* var contact.contact_message *}
                </td>
            </tr>
        </table><!--END table-->

        <br>

        <form id="reply" class="form-horizontal" role="form" action="{* link contact/reply *}" method="POST">

            {* tpl default/com_textarea rows=4 name=contact_message label=contact.reply value=contact.contact_reply *}

            {* tpl default/com_submit_btn caption=default.send *}

        </form>

    </div><!--END panel-body-->
</div><!--END panel-->
