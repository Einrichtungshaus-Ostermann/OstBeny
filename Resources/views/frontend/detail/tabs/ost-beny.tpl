
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
            <td>Marktplatz</td>
            <td>Info</td>
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
                        kein Preisvergleich gefunden
                    {else}
                        {* Datum: {$marketplace.date}<br /> *}
                        Rank: {$marketplace.ranking}<br />
                        Preis: {$marketplace.price}<br />
                        Händler: {$marketplace.competitor}
                    {/if}
                </td>

            </tr>
        {/foreach}

        </tbody>
    </table>

</div>
