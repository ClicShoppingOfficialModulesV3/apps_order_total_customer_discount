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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\OrderTotal\CustomerDiscount\CustomerDiscount as CustomerDiscountApp;

  class PageTabContent4 implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('CustomerDiscount')) {
        Registry::set('CustomerDiscount', new CustomerDiscountApp());
      }

      $this->app = Registry::get('CustomerDiscount');
    }

    public function display()
    {
      global $cInfo;

      if (!defined('CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS') || CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS == 'False') {
        return false;
      }

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Customers/page_content4');

      if (CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS == 'True') {
        $content = '<div class="mainTitle">';
        $content .= '<span class="col-md-12">' . $this->app->getDef('title_customer_discount') . '</span>';
        $content .= '</div>';
        $content .= '<div class="adminformTitle">';
        $content .= '<div class="row">';
        $content .= '<div class="col-md-5">';
        $content .= '<div class="form-group row">';
        $content .= '<label for="' . $this->app->getDef('text_customer_discount') . '" class="col-5 col-form-label">' . $this->app->getDef('text_customer_discount') . '</label>';
        $content .= '<div class="col-md-6">';
        $content .= '<span>' . HTML::inputField('customer_discount', $cInfo->customer_discount, 'maxlength="6"') . ' %</span>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        $output = <<<EOD
<!-- ######################## -->
<!--  Start CustomerDiscount App      -->
<!-- ######################## -->
<script>
$('#tab4Content').prepend(
    '{$content}'
);
</script>
<!-- ######################## -->
<!--  End  CustomerDiscount App       -->
<!-- ######################## -->

EOD;
        return $output;
      }
    }
  }
