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

  namespace ClicShopping\Apps\OrderTotal\CustomerDiscount\Sites\ClicShoppingAdmin\Pages\Home;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\OrderTotal\CustomerDiscount\CustomerDiscount;

  class Home extends \ClicShopping\OM\PagesAbstract
  {
    public mixed $app;

    protected function init()
    {
      $CLICSHOPPING_CustomerDiscount = new CustomerDiscount();
      Registry::set('CustomerDiscount', $CLICSHOPPING_CustomerDiscount);

      $this->app = $CLICSHOPPING_CustomerDiscount;

      $this->app->loadDefinitions('Sites/ClicShoppingAdmin/main');
    }
  }
