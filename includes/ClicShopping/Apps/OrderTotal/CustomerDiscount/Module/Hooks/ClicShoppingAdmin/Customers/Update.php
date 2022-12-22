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

  namespace ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\Hooks\ClicShoppingAdmin\Customers;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  use ClicShopping\Apps\OrderTotal\CustomerDiscount\CustomerDiscount as CustomerDiscountApp;

  class Update implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected mixed $app;

    public function __construct()
    {
      if (!Registry::exists('CustomerDiscount')) {
        Registry::set('CustomerDiscount', new CustomerDiscountApp());
      }

      $this->app = Registry::get('CustomerDiscount');
    }

    public function execute()
    {
      if (isset($_GET['Update'], $_GET['Customers'])) {
        if (isset($_POST['customer_discount'])) {
          $customer_discount = HTML::sanitize($_POST['customer_discount']);
        } else {
          $customer_discount = 0;
        }

        if (isset($_POST['customers_id'])) {
          $customers_id = HTML::sanitize($_POST['customers_id']);

          $sql_data_array = ['customer_discount' => (float)$customer_discount];

          $this->app->db->save('customers', $sql_data_array, ['customers_id' => (int)$customers_id]);
        }
      }
    }
  }