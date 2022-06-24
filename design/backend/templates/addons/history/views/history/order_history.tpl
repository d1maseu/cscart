
<div class="admin-content-wrapper">
    <div class="content page-content">
        <div class="content-wrap"> 
        {include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id} 
            <div class="table-responsive-wrapper longtap-selection">
                <table class="orders table">    
                    <thead>
                        <tr class="history-head">
                            <th class="history-head__item">
                               {include file="common/table_col_head.tpl" type="order_id" text=__("id")}
                            </th>
                            <th class="history-head__item">{__("user")}</th>
                            <th class="history-head__item">{__("date")}</th>
                            <th class="history-head__item">{__("old_state")}</th>
                            <th class="history-head__item">{__("new_state")}</th>
                        </tr>
                    </thead>
                    
                    {foreach from=$changed_orders item="order" key="key"}
                        <tr class="history__list">
                            <td>
                                {__("order")} #{$order.order_id}
                            </td>
                            <td class="history__item">
                                <a href="dispatch[profiles.update]?user_id={$order.user_id}">
                                    @
                                    {if $order.firstname || $order.lastname}
                                        {if $order.firstname}{$order.firstname}{/if}
                                        {if $order.lastname}{$order.lastname}{/if}
                                    {else if $order.email} {$order.email}   
                                    {/if}    
                                </a>
                            </td>
                            <td class="history__item" data-th="{__("date")}">
                            {$order['updated_at']|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}  
                            </td>
                            <td class="history__item">
                                {if is_array($order.data_old)}
                                    {if !empty($order.data_old['product'])}
                                        <h3 class="order-products">{__("products")}</h3>
                                        <ul>
                                            {foreach from=$order.data_old['product'] item="item" key="key"}
                                                <li>
                                                    <div>
                                                        <p class="h3"><b>{__("position")}:</b> <span>{$key}</span><p>
                                                        <p>{__("product_id")}: <span>{$item.product_id}</span></p>
                                                        <p>{__("product_name")}:<br><span>{$item.title}</span></p>
                                                        <p>{__("price")}: <span>{$item.price}</span></p>
                                                        <p>{__("quantity")}: <span>{$item.amount}</span></p>
                                                        {if !empty($item['options'])}
                                                            {foreach from=$item['options'] item="option" key="option_key"}
                                                                {if $option_key} 
                                                                    <p>{$option_key}: <span>{$option}</span></p> 
                                                                {/if}    
                                                            {/foreach}
                                                        {/if}
                                                    </div>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    {/if} 
                                    {if !empty($order.data_old['status'])}
                                        <h3 class="order-status">{__("status")}</h3> 
                                        <p>{$order.data_old['status']}</p>
                                    {/if}  
                                    {if !empty($order.data_old['shippings'])}
                                        <h3 class="order-shippings">{__("shipping")}</h3> 
                                        {foreach from=$order.data_old['shippings'] item="item" key="key"}
                                            <p>{$item}</p>
                                        {/foreach}
                                    {/if}
                                    {if !empty($order.data_old['payment'])}
                                        <h3 class="order-payment">{__("payment_method")}</h3> 
                                        <p>{$order.data_old['payment']}</p>
                                    {/if}
                                    {if !empty($order.data_old['payment_info'])}
                                        <h3 class="order-payment">{__("payment")}</h3> 
                                        {foreach from=$order.data_old['payment_info'] item="item" key="key"}
                                            <p>{__($key)}: {$item}</p>
                                        {/foreach}
                                    {/if}
                                {else}
                                    {$order['data_old']}
                                {/if}    
                            </td>        
                            <td class="history__item"">
                                {if is_array($order.data_new)}
                                    {if !empty($order.data_new['product'])}
                                        <h3 class="order-products">{__("products")}</h3>
                                        <ul>
                                        {foreach from=$order.data_new['product'] item="item" key="key"}
                                            <li>
                                                <div>
                                                    <p class="h3"><b>{__("position")}:</b> <span>{$key}</span><p>
                                                    <p>{__("product_id")}: <span>{$item.product_id}</span></p>
                                                    <p>{__("product_name")}:<br><span>{$item.title}</span></p>
                                                    <p>{__("price")}: <span>{$item.price}</span></p>
                                                    <p>{__("quantity")}: <span>{$item.amount}</span></p>
                                                    {if !empty($item['options'])}
                                                        {foreach from=$item['options'] item="option" key="option_key"}
                                                            {if $option_key} 
                                                                <p>{$option_key}: <span>{$option}</span></p> 
                                                            {/if}    
                                                        {/foreach}
                                                    {/if}
                                                </div>
                                            </li>
                                        {/foreach}
                                        </ul>
                                    {/if} 
                                    {if !empty($order.data_new['status'])}
                                        <h3 class="order-status">{__("status")}</h3>
                                        <p>{$order.data_new['status']}</p>
                                    {/if} 
                                    {if !empty($order.data_new['shippings'])}
                                        <h3 class="order-shippings">{__("shipping")}</h3> 
                                        {foreach from=$order.data_new['shippings'] item="item" key="key"}
                                            <p>{$item}</p>
                                        {/foreach}
                                    {/if}
                                    {if !empty($order.data_new['payment'])}
                                        <h3 class="order-payment">{__("payment_method")}</h3> 
                                        <p>{$order.data_new['payment']}</p>
                                    {/if}
                                    {if !empty($order.data_new['payment_info'])}
                                        <h3 class="order-payment">{__("payment")}</h3> 
                                        {foreach from=$order.data_new['payment_info'] item="item" key="key"}
                                            <p>{__($key)}: {$item}</p>
                                        {/foreach}
                                    {/if}  
                                {else}
                                    {$order.data_new}    
                                {/if}    
                            </td>  
                        </tr>    
                    {/foreach}
                </table>
            </div>  
            <div class="clearfix">
                {include file="common/pagination.tpl" div_id=$smarty.request.content_id}
            </div>  
        </div>
    </div>
</div> 
     