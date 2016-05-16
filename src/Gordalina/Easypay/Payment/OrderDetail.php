<?php

namespace Gordalina\Easypay\Payment;

class OrderDetail
{
    /**
     * @var string
     */
    protected $e;

    /**
     * @var string
     */
    protected $r;

    /**
     * @var string
     */
    protected $v;

    /**
     * @var string
     */
    protected $c;

    /**
     * @var string
     */
    protected $l;

    /**
     * @var string
     */
    protected $t_key;

    /**
     * @param string $e
     * @param string $r
     * @param string $v
     * @param string $c
     * @param string $l
     * @param string $t_key
     */
    public function __construct($e, $r, $v, $c, $l, $t_key)
    {
        $this->e = $e;
        $this->r = $r;
        $this->v = $v;
        $this->c = $c;
        $this->l = $l;
        $this->t_key = $t_key;
    }

    /**
     * @return  string
     */
    public function getE()
    {
        return $this->e;
    }

    /**
     * @return  string
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * @return  string
     */
    public function getV()
    {
        return $this->v;
    }

    /**
     * @return  string
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * @return  string
     */
    public function getL()
    {
        return $this->l;
    }

    /**
     * @return  string
     */
    public function getTKey()
    {
        return $this->t_key;
    }

    /**
     * @return PaymentNotification
     */
    public static function fromGlobals()
    {
        $attributes = $_GET;

        return new static(
            $attributes['e'],
            $attributes['r'],
            $attributes['v'],
            $attributes['c'],
            $attributes['l'],
            $attributes['t_key']
        );
    }

    /**
     * @param array $order
     * @return array
     */
    public function setXmlResponseFields(array $order = [])
    {
        $orderXmlResponseFields = [
            'order_info' => [
                'total_taxes' => isset($order['total_taxes']) ? $order['total_taxes'] : null,
                'total_including_taxes' => isset($order['total_including_taxes']) ? $order['total_including_taxes'] : null,
                'bill_fiscal_number' => isset($order['bill_fiscal_number']) ? $order['bill_fiscal_number'] : null,
                'bill_name' => isset($order['bill_name']) ? $order['bill_name'] : null,
                'bill_address_1' => isset($order['bill_address_1']) ? $order['bill_address_1'] : null,
                'bill_address_2' => isset($order['bill_address_2']) ? $order['bill_address_2'] : null,
                'bill_city' => isset($order['bill_city']) ? $order['bill_city'] : null,
                'bill_zip_code' => isset($order['bill_zip_code']) ? $order['bill_zip_code'] : null,
                'bill_country' => isset($order['bill_country']) ? $order['bill_country'] : null,
                'shipp_fiscal_number' => isset($order['shipp_fiscal_number']) ? $order['shipp_fiscal_number'] : null,
                'shipp_name' => isset($order['shipp_name']) ? $order['shipp_name'] : null,
                'shipp_address_1' => isset($order['shipp_address_1']) ? $order['shipp_address_1'] : null,
                'shipp_address_2' => isset($order['shipp_address_2']) ? $order['shipp_address_2'] : null,
                'shipp_city' => isset($order['shipp_city']) ? $order['shipp_city'] : null,
                'shipp_zip_code' => isset($order['shipp_zip_code']) ? $order['shipp_zip_code'] : null,
                'shipp_country' => isset($order['shipp_country']) ? $order['shipp_country'] : null,
            ],
        ];

        $orderXmlResponseFields['order_detail'] = [
            'item' => [],
        ];
        if(isset($order['items']) && is_array($order['items'])) {
            foreach($order['items'] as $item) {
                $orderXmlResponseFields['order_detail']['item'][] = [
                    'item_description' => isset($item['item_description']) ? $item['item_description'] : null,
                    'item_quantity' => isset($item['item_quantity']) ? $item['item_quantity'] : null,
                    'item_total' => isset($item['item_total']) ? $item['item_total'] : null,
                ];
            }
        }

        return $orderXmlResponseFields;
    }

    /**
     * @see https://docs.easypay.pt/workflow/order-detail
     *
     * @param array $order
     * @return string
     */
    public function getXmlResponse(array $order = [])
    {
        $orderXmlResponseFields = $this->setXmlResponseFields($order);

        $orderXml =<<<EOF
<order_info>
        <total_taxes>{$orderXmlResponseFields['order_info']['total_taxes']}</total_taxes>
        <total_including_taxes>{$orderXmlResponseFields['order_info']['total_including_taxes']}</total_including_taxes>
        <bill_fiscal_number>{$orderXmlResponseFields['order_info']['bill_fiscal_number']}</bill_fiscal_number>
        <bill_name>{$orderXmlResponseFields['order_info']['bill_name']}</bill_name>
        <bill_address_1>{$orderXmlResponseFields['order_info']['bill_address_1']}</bill_address_1>
        <bill_address_2>{$orderXmlResponseFields['order_info']['bill_address_2']}</bill_address_2>
        <bill_city>{$orderXmlResponseFields['order_info']['bill_city']}</bill_city>
        <bill_zip_code>{$orderXmlResponseFields['order_info']['bill_zip_code']}</bill_zip_code>
        <bill_country>{$orderXmlResponseFields['order_info']['bill_country']}</bill_country>
        <shipp_fiscal_number>{$orderXmlResponseFields['order_info']['shipp_fiscal_number']}</shipp_fiscal_number>
        <shipp_name>{$orderXmlResponseFields['order_info']['shipp_name']}</shipp_name>
        <shipp_address_1>{$orderXmlResponseFields['order_info']['shipp_address_1']}</shipp_address_1>
        <shipp_address_2>{$orderXmlResponseFields['order_info']['shipp_address_2']}</shipp_address_2>
        <shipp_city>{$orderXmlResponseFields['order_info']['shipp_city']}</shipp_city>
        <shipp_zip_code>{$orderXmlResponseFields['order_info']['shipp_zip_code']}</shipp_zip_code>
        <shipp_country>{$orderXmlResponseFields['order_info']['shipp_country']}</shipp_country>
</order_info>
    <order_detail>
EOF;

        foreach($orderXmlResponseFields['order_detail']['item'] as $orderDetailItem) {

            $orderXml .=<<<EOF

        <item>
            <item_description>{$orderDetailItem['item_description']}</item_description>
            <item_quantity>{$orderDetailItem['item_quantity']}</item_quantity>
            <item_total>{$orderDetailItem['item_total']}</item_total>
</item>
EOF;
        }

        $orderXml .=<<<EOF

</order_detail>
EOF;

        $xml =<<<EOF
<!--?xml version="1.0" encoding="ISO-8859-1"?-->
<get_detail>
    <ep_status>ok</ep_status>
    <ep_message>success message</ep_message>
    <ep_entity>%s</ep_entity>
    <ep_reference>%s</ep_reference>
    <ep_value>%s</ep_value>
    <t_key>%s</t_key>
    $orderXml
</get_detail>
EOF;

        return trim(sprintf($xml, $this->e, $this->r, $this->v, $this->t_key));
    }
}
