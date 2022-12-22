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
  use ClicShopping\OM\ObjectInfo;

  use ClicShopping\Apps\OrderTotal\CustomerDiscount\CustomerDiscount as CustomerDiscountApp;

  class pageTab4 implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected mixed $app;

    public function __construct()
    {
      if (!Registry::exists('CustomerDiscount')) {
        Registry::set('CustomerDiscount', new CustomerDiscountApp());
      }

      $this->app = Registry::get('CustomerDiscount');
    }

    public function display()
    {
        $CLICSHOPPING_Customers = Registry::get('Customers');

      if (!\defined('CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS') || CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS == 'False') {
        return false;
      }

      $Qcustomers = $CLICSHOPPING_Customers->db->prepare('select customer_discount
                                                          from :table_customers
                                                          where customers_id = :customers_id
                                                         ');
      $Qcustomers->bindInt(':customers_id', $_GET['cID']);
      $Qcustomers->execute();

      $cInfo = new ObjectInfo($Qcustomers->toArray());

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/Customers/page_content4');


      if (CLICSHOPPING_APP_ORDER_TOTAL_CUSTOMER_DISCOUNT_CD_STATUS == 'True') {
        $content = '<div class="tab-pane" id="section_DiscountCustomerApp_content">';
        $content .= '<div class="mainTitle">';
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
        $content .= '</div>';


        $title = $this->app->getDef('title_customer_discount');
        $tab_title = $this->app->getDef('text_customer_discount');

        $output = <<<EOD
<!-- ######################## -->
<!--  Start CustomerDiscount App      -->
<!-- ######################## -->

  {$content}

<script>
$('#section_DiscountCustomerApp_content').appendTo('#customersTabs .tab-content');
$('#customersTabs .nav-tabs').append('    <li class="nav-item"><a data-bs-target="#section_DiscountCustomerApp_content" role="tab" data-bs-toggle="tab" class="nav-link">{$tab_title}</a></li>');
</script>

<!-- ######################## -->
<!--  End  CustomerDiscount App       -->
<!-- ######################## -->

EOD;
        return $output;
      }
    }
  }
