<?php

class Iunctim_AutoShipping_Model_Observer_Checkout_Cart {

   protected function updateShippingAddress() {
      // Update the cart's quote.
      $grandTotal = Mage::getSingleton('checkout/cart')->getQuote()->getGrandTotal();
      $totals = Mage::getSingleton('checkout/cart')->getQuote()->getTotals();
      $shipping = isset($totals['shipping'])?$totals['shipping']->getValue():0.00;
      $shippingTax = round($shipping * 19 / 100,2);
      $grandTotalWithoutShipping = $grandTotal - $shipping - $shippingTax;

      /** @var $onepage Mage_Checkout_Model_Type_Onepage */
      $onepage = Mage::getSingleton('checkout/type_onepage');
      

      // Add address to cart
      $address = $onepage->getQuote()->getShippingAddress();

      if (null == $address->getCountryId())
      {
         $country = 'DE';
         $address->setCountryId($country);
      }

      if ( null == $address->getPostcode() )
      {
         $address->setPostcode('00000');
      }

      if($grandTotalWithoutShipping >= 19) {
        $address->setShippingMethod("freeshipping_freeshipping"); // <<<<<
      } else {
        $address->setShippingMethod("flatrate_flatrate"); // <<<<<
      }

      $address->setCollectShippingrates(true);

      // save settings
      $onepage->getQuote()->collectTotals()->save();
      $onepage->getQuote()->save();
   }

   function addProductComplete ( Varien_Event_Observer $observer )
   {
      Mage::Log("add product");
      self::updateShippingAddress(); 
   }

   function removeProductComplete ( Varien_Event_Observer $observer )
   {
      Mage::Log("remove product");
      $onepage = Mage::getSingleton('checkout/type_onepage');
      $onepage->getQuote()->collectTotals()->save();
      self::updateShippingAddress(); 
   }

   function updateProductComplete ( Varien_Event_Observer $observer )
   {
      Mage::Log("update product");
      $onepage = Mage::getSingleton('checkout/type_onepage');
      $onepage->getQuote()->collectTotals()->save();
      self::updateShippingAddress(); 
      $quote = Mage::getSingleton('checkout/session')->getQuote();
      $quote->save();
   }

}

?>
