<?php

class Parassood_Commentmarker_Model_Order_Invoice extends Mage_Sales_Model_Order_Invoice
{


    /**
     * Adds comment to invoice with additional possibility to send it to customer via email
     * and show it in customer account
     *
     * @param bool $notify
     * @param bool $visibleOnFront
     *
     * @return Mage_Sales_Model_Order_Invoice
     */
    public function addComment($comment, $notify=false, $visibleOnFront=false)
    {
        if (!($comment instanceof Mage_Sales_Model_Order_Invoice_Comment)) {
            $comment = Mage::getModel('sales/order_invoice_comment')
                ->setComment($comment)
                ->setIsCustomerNotified($notify)
                ->setIsVisibleOnFront($visibleOnFront);
        }
        $comment->setInvoice($this)
            ->setStoreId($this->getStoreId())
            ->setParentId($this->getId());
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