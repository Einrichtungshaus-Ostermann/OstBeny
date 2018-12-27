
{* set namespace *}
{namespace name="widgets/ost-store-stock/get-stock-table"}



{* our table *}
<table class="ost-store-stock--detail-tab--table">
    <thead>
    <tr>
        <td>OSTERMANN CENTRUM</td>
        <td>Bestand</td>
        <td>Ausstellung</td>
        <td>Koje</td>
    </tr>
    </thead>
    <tbody>

    {* every store *}
    {foreach $ostStoreStock.stores as $store}
        <tr>

            <td>
                {$store->getCity()}
            </td>

            {* summed up stock *}
            {$inStock = 0}

            {* sum up *}
            {foreach $ostStoreStock.article->getAvailableStock() as $stock}
                {if $stock->getStore()->getKey() == $store->getKey()}
                    {$inStock = $stock->getQuantity()}
                {/if}
            {/foreach}

            <td>
                {$inStock}
            </td>

            {* in store? *}
            {$inStore = false}
            {$exhibitStock = null}

            {* check every stock *}
            {foreach $ostStoreStock.article->getExhibits() as $exhibit}
                {if $exhibit->getLocation()->getStore()->getKey() == $store->getKey()}
                    {$inStore = true}
                    {$exhibitStock = $exhibit}
                {/if}
            {/foreach}

            <td>
                {if $inStore == true}
                    <li class="icon--cd" style="color: #339900;"></li>
                {else}
                    <li class="icon--cd" style="color: #a12726;"></li>
                {/if}
            </td>

            <td>
                {if $inStore == true}
                    {$exhibitStock->getArea()}
                {else}
                    &nbsp;
                {/if}
            </td>

        </tr>
    {/foreach}

    </tbody>
</table>
