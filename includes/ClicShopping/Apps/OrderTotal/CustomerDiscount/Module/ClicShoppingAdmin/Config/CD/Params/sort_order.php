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

  namespace ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\ClicShoppingAdmin\Config\CD\Params;

  class sort_order extends \ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\ClicShoppingAdmin\Config\ConfigParamAbstract
  {

    public $default = '1200';
    public bool $app_configured = false;

    protected function init()
    {
      $this->title = $this->app->getDef('cfg_order_total_customer_discount_sort_order_title');
      $this->description = $this->app->getDef('cfg_order_total_customer_discount_sort_order_description');
    }
  }
