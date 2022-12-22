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

  namespace ClicShopping\Apps\OrderTotal\CustomerDiscount;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class CustomerDiscount extends \ClicShopping\OM\AppAbstract
  {

    protected $api_version = 1;
    protected string $identifier = 'ClicShopping_CustomerDiscount_V1';

    protected function init()
    {
    }

    /**
     * @return array|mixed
     */
    public function getConfigModules(): mixed
    {
      static $result;

      if (!isset($result)) {
        $result = [];

        $directory = CLICSHOPPING::BASE_DIR . 'Apps/OrderTotal/CustomerDiscount/Module/ClicShoppingAdmin/Config';
        $name_space_config = 'ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\ClicShoppingAdmin\Config';
        $trigger_message = 'ClicShopping\Apps\OrderTotal\CustomerDiscount\CustomerDiscount::getConfigModules(): ';

        $this->getConfigApps($result, $directory, $name_space_config, $trigger_message);
      }

      return $result;
    }

    public function getConfigModuleInfo($module, $info)
    {
      if (!Registry::exists('CustomerDiscountAdminConfig' . $module)) {
        $class = 'ClicShopping\Apps\OrderTotal\CustomerDiscount\Module\ClicShoppingAdmin\Config\\' . $module . '\\' . $module;
        Registry::set('CustomerDiscountAdminConfig' . $module, new $class);
      }

      return Registry::get('CustomerDiscountAdminConfig' . $module)->$info;
    }


    public function getApiVersion()
    {
      return $this->api_version;
    }

     /**
     * @return string
     */
    public function getIdentifier() :String
    {
      return $this->identifier;
    }
  }
