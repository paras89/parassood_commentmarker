<?php

class Parassood_Commentmarker_Model_Order extends Mage_Sales_Model_Order
{


    /*
     * Add a comment to order
     * Different or default status may be specified
     *
     * @param string $comment
     * @param string $status
     * @return Mage_Sales_Model_Order_Status_History
     */
    public function addStatusHistoryComment($comment, $status = false)
    {
        if (false === $status) {
            $status = $this->getStatus();
        } elseif (true === $status) {
            $status = $this->getConfig()->getStateDefaultStatus($this->getState());
        } else {
            $this->setStatus($status);
        }

        $history = Mage::getModel('sales/order_status_history')
            ->setStatus($status)
            ->setComment($comment)
            ->setEntityName($this->_historyEntityName);
        $adminUser = Mage::getSingleton('admin/session')->getUser();
        $userId = $adminUser->getId();
        if (isset($userId)) {
            $adminName = $adminUser->getFirstname() . ' ' . $adminUser->getLastname();
            $history->setAdminuserName($adminName);
        }
        $this->addStatusHistory($history);
        return $history;
    }


}