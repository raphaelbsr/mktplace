<?php

namespace raphaelbsr\mktplace\interfaces;

/**
 * Description of ConsumerInterface
 *
 * @author rapha
 */
interface ConsumerInterface {
    
    /**
     * Returns an token that can uniquely identify a Consumer.
     * @return string|int an Tonek that uniquely identifies a Consumer.
     */
    public function getMktToken();
    
    /**
     * Returns an array with Consumer Credit Cards Informations or a MktCreditCardObject.
     * @return array|int an Tonen that uniquely identifies a Consumer.
     */
    public function getCreditCard();
    
}
