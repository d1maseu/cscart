<div class="container">    
    <h1 class="h1">История изменения данных по заказу</h1>
    <table class="orders ty-table" border="1">    
        <thead>
            <tr>
                <th class="ty-orders-detail__table-product">{__("order_id")}</th>
                <th class="ty-orders-detail__table-price">{__("user")}</th>
                <th class="ty-orders-detail__table-quantity">{__("date")}</th>
                <th class="ty-orders-detail__table-quantity">{__("old_state")}</th>
                <th class="ty-orders-detail__table-quantity">{__("new_state")}</th>
            </tr>
        </thead>
        
        {foreach from=$changed_orders item="order" key="key"}
            <tr class="ty-valign-top">
                <td>
                    #{$order['order_id']}
                </td>
                <td class="ty-right">
                    <a href="?dispatch=profiles.update&user_id={$order['user_id']}">{$order['firstname']}</a>
                </td>
                <td class="ty-right" data-th="{__("date")}">
                {$order['updated_at']|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}  
                </td>
                <td class="ty-right">
                    {if is_array($order['data_old'])}
                        <h3>{__("products")}</h3>
                        <ul>
                            {foreach from=$order['data_old'] item="item" key="key"}
                                <li>
                                    <div>
                                        <p class="h3"><b>{__("position")}:</b> <span>{$key}</span><p>
                                        <p>{__("product_id")}: <span>{$item['product_id']}</span></p>
                                        <p>{__("price")}: <span>{$item['price']}</span></p>
                                        <p>{__("quantity")}: <span>{$item['amount']}</span></p>
                                    </div>
                                </li>
                            {/foreach}
                    {else}
                        {$order['data_old']}
                    {/if}    
                </td>        
                <td class="ty-center">
                    {if is_array($order['data_new'])}
                        <h3>{__("products")}</h3>
                        <ul>
                        {foreach from=$order['data_new'] item="item" key="key"}
                            <li>
                                <div>
                                    <p class="h3"><b>{__("position")}:</b> <span>{$key}</span><p>
                                    <p>{__("product_id")}: <span>{$item['product_id']}</span></p>
                                    <p>{__("price")}: <span>{$item['price']}</span></p>
                                    <p>{__("quantity")}: <span>{$item['amount']}</span></p>
                                </div>
                            </li>
                        {/foreach}
                        </ul>
                    {else}
                        {$order['data_new']}    
                    {/if}    
                </td>  
            </tr>    
        {/foreach}
    </table>
</div>    