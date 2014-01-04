<div class="text-center">
    <ul class="pagination">
        {* if arrow.show == 'yes' *}
        <li><a href="{* raw arrow.first *}">&laquo;</a></li>
        <li><a href="{* raw arrow.previous *}">&lsaquo;</a></li>
        {* endif arrow.show *}

        {* foreach groups *}

        {* if groups.space == 'yes' *}
         <li class="disabled"><a href="#">...</a></li>
        {* endif groups.space *}

        {* foreach groups.links *}

        {* if links.active == 'yes' *}
        <li class="active"><a href="#">{* raw links.page *} <span class="sr-only">(current)</span></a></li>
        {* else links.active *}
         <li><a href="{* raw links.href *}">{* raw links.page *}</a></li>
        {* endif links.active *}

        {* endforeach groups.links *}

        {* endforeach groups *}

        {* if arrow.show == 'yes' *}
        <li><a href="{* raw arrow.next *}">&rsaquo;</a></li>
        <li><a href="{* raw arrow.last *}">&raquo;</a></li>
        {* endif arrow.show *}
    </ul><!--END default-pages pagination-->
</div><!--END default-pages-->