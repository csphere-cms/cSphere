<div class="panel panel-default">
    <div class="panel-body">

        {* tpl default/com_header plugin=contact action=default.create *}

        <br />

        <form class="form-horizontal" role="form" action="{* link contact/create *}" method="POST">

            {* tpl default/com_input name=contact_name label=name value=contact.contact_name *}

            {* tpl default/com_input name=contact_mail label=mail value=contact.contact_mail *}

            {* tpl default/com_input name=contact_url label=url value=contact.contact_url *}

            {* tpl default/com_input name=contact_subject label=subject value=contact.contact_subject *}

            {* tpl default/com_textarea rows=4 name=contact_message label=message value=contact.contact_message *}

            {* tpl default/com_submit_btn caption=default.save *}

        </form><!--END form-->

    </div><!--END panel-body-->
</div><!--END panel-->