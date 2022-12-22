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

  namespace ClicShopping\Apps\OrderTotal\CustomerDiscount\Sites\ClicShoppingAdmin\Pages\Home\Actions\Configure;

  use ClicShopping\OM\Registry;

  class Uninstall extends \ClicShopping\OM\PagesActionsAbstract
  {

    public function execute()
    {

      $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
      $CLICSHOPPING_CustomerDiscount = Registry::get('CustomerDiscount');

      $current_module = $this->page->data['current_module'];

      $m = Registry::get('CustomerDiscountAdminConfig' . $current_module);
      $m->uninstall();

      $CLICSHOPPING_MessageStack->add($CLICSHOPPING_CustomerDiscount->getDef('alert_module_uninstall_success'), 'success');

      $CLICSHOPPING_CustomerDiscount->redirect('Configure&module=' . $current_module);
    }
  }