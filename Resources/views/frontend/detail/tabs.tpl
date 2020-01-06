
{* file to extend *}
{extends file="parent:frontend/detail/tabs.tpl"}

{* set namespace *}
{namespace name="frontend/ost-beny/detail/tabs"}



{* tab navigation *}
{block name="frontend_detail_tabs_description"}

    {* smarty parent *}
    {$smarty.block.parent}

    {* append our tab *}
    <a href="#" class="tab--link" title="{s name="tab-header-title"}Preisvergleich{/s}" data-tabName="ost-beny">{s name="tab-header-name"}Preisvergleich{/s}</a>

{/block}



{* tab content *}
{block name="frontend_detail_tabs_content_description"}

    {* smarty parent *}
    {$smarty.block.parent}

    {* our tab container *}
    <div class="tab--container">
        <div class="tab--header">
            <a href="#" class="tab--title" title="{s name="tab-container-title"}Preisvergleich{/s}">{s name="tab-container-name"}Preisvergleich{/s}</a>
        </div>
        <div class="tab--preview">
            {s name="tab-container-preview"}Preisvergleich hier...{/s}
        </div>
        <div class="tab--content">
            {include file="frontend/detail/tabs/ost-beny.tpl"}
        </div>
    </div>

{/block}
