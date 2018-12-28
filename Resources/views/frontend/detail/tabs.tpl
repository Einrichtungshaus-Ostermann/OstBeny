
{* file to extend *}
{extends file="parent:frontend/detail/tabs.tpl"}

{* set namespace *}
{namespace name="frontend/ost-beny/detail/tabs"}



{* tab navigation *}
{block name="frontend_detail_tabs_description"}

    {* smarty parent *}
    {$smarty.block.parent}

    {* append our tab *}
    <a href="#" class="tab--link" title="Preisvergleich" data-tabName="ost-beny">Preisvergleich</a>

{/block}



{* tab content *}
{block name="frontend_detail_tabs_content_description"}

    {* smarty parent *}
    {$smarty.block.parent}

    {* our tab container *}
    <div class="tab--container">
        <div class="tab--header">
            <a href="#" class="tab--title" title="Verfügbarkeit">Preisvergleich</a>
        </div>
        <div class="tab--preview">
            Preisvergleich hier...
        </div>
        <div class="tab--content">
            {include file="frontend/detail/tabs/ost-beny.tpl"}
        </div>
    </div>

{/block}
