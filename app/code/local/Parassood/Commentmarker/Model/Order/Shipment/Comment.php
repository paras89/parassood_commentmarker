<?php


class Parassood_Commentmarker_Model_Order_Shipment_Comment extends Mage_Sales_Model_Order_Shipment_Comment
{


    /**
     * Before object save
     *
     * @return Parassood_Commentmarker_Model_Order_Shipment_Comment
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $adminUser = Mage::getSingleton('admin/session')->getUser();
        $userId = $adminUser->getId();

        if (isset($userId)) {

            $adminName = $adminUser->getFirstname() . ' ' . $adminUser->getLastname();
            $this->setAdminuserName($adminName);
        }

        return $this;
    }
}
