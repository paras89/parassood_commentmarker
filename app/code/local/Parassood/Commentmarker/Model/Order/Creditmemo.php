<?php

class Parassood_Commentmarker_Model_Order_Creditmemo extends Mage_Sales_Model_Order_Creditmemo
{

    /**
     * Adds comment to credit memo with additional possibility to send it to customer via email
     * and show it in customer account
     *
     * @param string $comment
     * @param bool $notify
     * @param bool $visibleOnFront
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function addComment($comment, $notify=false, $visibleOnFront=false)
    {
        if (!($comment instanceof Mage_Sales_Model_Order_Creditmemo_Comment)) {
            $comment = Mage::getModel('sales/order_creditmemo_comment')
                ->setComment($comment)
                ->setIsCustomerNotified($notify)
                ->setIsVisibleOnFront($visibleOnFront);
        }
        $comment->setCreditmemo($this)
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