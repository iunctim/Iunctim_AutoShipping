<?php

class Iunctim_AutoShipping_Model_Observer_Checkout_Cart {

   function addProductComplete ( Varien_Event_Observer $observer )
   {
      Mage::log("hey");
      // Update the cart's quote.
      /** @var $onepage Mage_Checkout_Model_Type_Onepage */
      /*$onepage = Mage::getSingleton('checkout/type_onepage');
      $onepage->saveShippingMethod("HIER DIE SHIPPING METHOD"); // <<<<<

      // Add address to cart
      $address = $onepage->getQuote()->getShippingAddress();

      if (null == $address->getCountryId())
      {
         $country = Mage::helper('core')->getDefaultCountry(); // use default country
         if ( '' == $country )
         {
            $country = 'DE';
         }
         $address->setCountryId($country);
      }

      if ( null == $address->getPostcode() )
      {
         $address->setPostcode('00000');
      }

      $address->setCollectShippingrates(true);

      // save settings
      $onepage->getQuote()->collectTotals()->save();
      $onepage->getQuote()->save();
      */
   }

}

?>
