<?php

class Parassood_Commentmarker_Model_Order_Shipment extends Mage_Sales_Model_Order_Shipment
{

    /**
     * Adds comment to shipment with additional possibility to send it to customer via email
     * and show it in customer account
     *
     * @param bool $notify
     * @param bool $visibleOnFront
     *
     * @return Mage_Sales_Model_Order_Shipment
     */
    public function addComment($comment, $notify=false, $visibleOnFront=false)
    {
        if (!($comment instanceof Mage_Sales_Model_Order_Shipment_Comment)) {
            $comment = Mage::getModel('sales/order_shipment_comment')
                ->setComment($comment)
                ->setIsCustomerNotified($notify)
                ->setIsVisibleOnFront($visibleOnFront);
        }
        $comment->setShipment($this)
            ->setParentId($this->getId())
            ->setStoreId($this->getStoreId());

        $adminUser = Mage::getSingleton('admin/session')->getUser();
        $userId = $adminUser->getId();
        if (isset($userId)) {
            $adminName = $adminUser->getFirstname() . ' ' . $adminUser->getLastname();
            $comment->setAdminuserName($adminName);
        }
        if (!$comment->getId()) {
            $this->getCommentsCollection()->addItem($comment);
        }
        $this->_hasDataChanges = true;
        return $this;
    }



}