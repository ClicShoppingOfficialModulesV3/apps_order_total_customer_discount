<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\Total;

  use ClicShopping\OM\Registry;

  use ClicShopping\Sites\Common\B2BCommon;

  use ClicShopping\Apps\OrderTotal\CustomerDiscount\CustomerDiscount as CustomerDiscountApp;

  class CD implements \ClicShopping\OM\Modules\OrderTotalInterface
  {
    public string $code;
    public $title;
    public $description;
    public $enabled;
    public $group;
    public $output;
    public ?int $sort_order = 0;
    public mixed $app;
    public $include_shipping;
    public $signature;
    public $public_title;
    protected $api_version;

    public function __construct()
    {

      if (!Registry::exists('CustomerDiscount')) {
        Registry::set('CustomerDiscount', new CustomerDiscountApp());
      }

      $this->app = Registry::get('CustomerDiscount');
      $this->app->loadDefinitions('Module/Shop/CD/CD');

      $this->signature = 'Tax|' . $this->app->getVersion() . '|1.0';
      $this->api_version = $this->app->getApiVersion();

      $this->code = 'CD';
      $this->title = $this->app->getDef('module_cd_title');
      $this->public_title = $this->app->getDef('module_cd_public_title');

       $this->enabled = \defined('CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS') && (CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS == 'True') ? true : false;

      $this->sort_order = \defined('CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_SORT_ORDER') && ((int)CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_SORT_ORDER > 0) ? (int)CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_SORT_ORDER : 0;

      $this->output = [];
    }

      /**
       * @param bool $amount
       * @return int
       */
    private function calculateDiscount($amount)
    {
      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Order = Registry::get('Order');

      $od_amount = 0;
      $tod_amount = 0;

      $calculate_tax = CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_CALCULATE_TAX;

      $QCustomerDiscount = $CLICSHOPPING_Db->prepare('select customer_discount
                                                      from :table_customers
                                                      where customers_id = :customers_id
                                                     ');
      $QCustomerDiscount->bindInt(':customers_id', (int)$CLICSHOPPING_Customer->getID());
      $QCustomerDiscount->execute();

      $customer_discount = $QCustomerDiscount->value('customer_discount');

      if ($customer_discount > 0) {
        if ($calculate_tax == 'True') {
// Calculate main tax reduction
          $tod_amount = round($CLICSHOPPING_Order->info['tax']*10)/10*$customer_discount/100;

          $CLICSHOPPING_Order->info['tax'] = $CLICSHOPPING_Order->info['tax'] - $tod_amount;
// Calculate tax group deductions 
          reset($CLICSHOPPING_Order->info['tax_groups']);
          foreach ($CLICSHOPPING_Order->info['tax_groups'] as $key => $value) {
            $god_amount = round($value*10)/10*$customer_discount/100;
            $CLICSHOPPING_Order->info['tax_groups'][$key] = $CLICSHOPPING_Order->info['tax_groups'][$key] - $god_amount;
          }
        }

         $od_amount = (round($amount*10)/10)*$customer_discount/100;
         $CLICSHOPPING_Order->info['total'] -= $tod_amount;
      }

      return $od_amount;
    }

      /**
       * @return float
       */
    private function getOrderTotal() :float
    {
      $CLICSHOPPING_Order = Registry::get('Order');

      $order_total = $CLICSHOPPING_Order->info['total'];
      $include_shipping = CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_INCLUDE_SHIPPING;
      $include_tax = CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_INCLUDE_TAX;

      if ($include_tax == 'False') {
          $order_total = $order_total - $CLICSHOPPING_Order->info['tax'];
      }

      if ($include_shipping == 'False') {
          $order_total = $order_total - $CLICSHOPPING_Order->info['shipping_cost'];
      }

      return $order_total;
    }

      public function process()
      {
          $CLICSHOPPING_Currencies = Registry::get('Currencies');
          $CLICSHOPPING_Order = Registry::get('Order');

          $od_amount = $this->calculateDiscount($this->getOrderTotal());

          if ($od_amount > 0) {
              $this->deduction = $od_amount;
              $this->output[] = [
                  'title' => $this->title . ':',
                  'text' => $CLICSHOPPING_Currencies->format($od_amount),
                  'value' => $od_amount
              ];

             // $CLICSHOPPING_Order->info['total'] = $CLICSHOPPING_Order->info['total'] - $od_amount;
              $CLICSHOPPING_Order->info['subtotal'] -= $od_amount;
          }
      }
    public function check()
    {
      return \defined('CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS') && (trim(CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS) != '');
    }

    public function install()
    {
      $this->app->redirect('Configure&Install&module=CD');
    }

    public function remove()
    {
      $this->app->redirect('Configure&Uninstall&module=CD');
    }

    public function keys()
    {
      return array('CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_SORT_ORDER');
    }
  }
