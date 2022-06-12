<?php
/***************************************************************************
 *                                                                          *
 *   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/

namespace Tygh\Addons\StorefrontRestApi\Payments;

use Tygh\Common\OperationResult;
use Tygh\Tygh;
use Tygh\Addons\Stripe\Payments\Stripe as StripePayment;

class Stripe implements IDirectPayment, IConfigurablePayment
{
    /** @var array<string|array> $order_info */
    protected $order_info;

    /** @var array<string|array> $auth_info */
    protected $auth_info;

    /** @var array<string|array> $payment_info */
    protected $payment_info;

    const PAYMENT_INTENT_STATUS_SUCCEDED = 'succeeded';

    /** @inheritDoc */
    public function pay(array $request)
    {
        return new OperationResult(false);
    }

    /** @inheritDoc */
    public function setOrderInfo(array $order_info)
    {
        $this->order_info = $order_info;

        return $this;
    }

    /** @inheritDoc */
    public function setAuthInfo(array $auth_info)
    {
        $this->auth_info = $auth_info;

        return $this;
    }

    /** @inheritDoc */
    public function setPaymentInfo(array $payment_info)
    {
        $this->payment_info = $payment_info;

        return $this;
    }

    /** @inheritDoc */
    public function getProcessorParameters(array $payment_method)
    {
        return [
            'publishable_key' => $payment_method['processor_params']['publishable_key'],
            'merchant_identifier' => $payment_method['processor_params']['merchant_identifier'],
            'country'         => $payment_method['processor_params']['country'],
            'currency'        => $payment_method['processor_params']['currency'],
        ];
    }

    /** @inheritDoc */
    public function confirmPayment(array $payment_method, $payment_method_id, array $order_info)
    {
        $processor = new StripePayment(
            $payment_method['payment_id'],
            Tygh::$app['db'],
            Tygh::$app['addons.stripe.price_formatter']
        );

        $result = new OperationResult(false);

        $result = $processor->getPaymentConfirmationDetails($payment_method_id, $order_info['total']);

        return $result;
    }
}
