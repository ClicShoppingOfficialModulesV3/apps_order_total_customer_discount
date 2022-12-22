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

  use ClicShopping\OM\HTML;

  class include_tax extends \ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\ClicShoppingAdmin\Config\ConfigParamAbstract
  {
    public $default = 'False';
    public ?int $sort_order = 30;

    protected function init()
    {
      $this->title = $this->app->getDef('cfg_order_total_customer_discount_include_tax_title');
      $this->description = $this->app->getDef('cfg_order_total_customer_discount_include_tax_description');
    }

    public function getInputField()
    {
      $value = $this->getInputValue();

      $input = HTML::radioField($this->key, 'True', $value, 'id="' . $this->key . '1" autocomplete="off"') . $this->app->getDef('cfg_order_total_customer_discount_include_tax_true') . ' ';
      $input .= HTML::radioField($this->key, 'False', $value, 'id="' . $this->key . '2" autocomplete="off"') . $this->app->getDef('cfg_order_total_customer_discount_include_tax_false');

      return $input;
    }
  }