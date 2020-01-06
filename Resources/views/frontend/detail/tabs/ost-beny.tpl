
{* set namespace *}
{namespace name="frontend/ost-beny/detail/tabs/ost-beny"}



{* offcanvas button *}
<div class="buttons--off-canvas">
    <a href="#" title="{"{s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}"|escape}" class="close--off-canvas">
        <i class="icon--arrow-left"></i>
        {s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
    </a>
</div>

{* the tab content *}
<div class="content--ost-beny">

    {* our table *}
    <table class="ost-beny--detail-tab--table">
        <thead>
        <tr>
            <td>{s name="header-marketplace"}Marktplatz{/s}</td>
            <td>{s name="header-info"}Info{/s}</td>
        </tr>
        </thead>
        <tbody>

        {* every store *}
        {foreach $ostBeny.marketplaces as $marketplace}
            <tr>

                <td>
                    {$marketplace.name}
                </td>

                <td>
                    {if $marketplace.id == 0 || $marketplace.ranking == 0 || $marketplace.price == 0}
                        {s name="no-price-comparison-found"}kein Preisvergleich gefunden{/s}
                    {else}
                        {* Datum: {$marketplace.date}<br /> *}
                        {s name="label-rank"}Rank:{/s} {$marketplace.ranking}<br />
                        {s name="label-price"}Preis:{/s} {$marketplace.price}<br />
                        {s name="label-merchant"}Händler:{/s}: {$marketplace.competitor}
                    {/if}
                </td>

            </tr>
        {/foreach}

        </tbody>
    </table>

</div>
