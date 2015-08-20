<?php

/**
 * default actions.
 *
 * @package    armenian.loc
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
    }

    /*
     * Реализует тестовое здание возвращает объект продукта если такой существует 
     * или false;
     */

    public function executeProduct(sfWebRequest $request) {

        //возвращаем объект json для нашего фронтенд
        // заголовок
        $this->getResponse()->setContentType('application/json');

        //реализован ОРМ Пропел, испотльзуем его прелести + дописаные кастомные методы;
        $productID = $request->getParameter('id');
        $product   = ProductPeer::retrieveByPK($productID);
        if (is_object($product)) {
            $result = ProductPeer::getProductDetails($productID);
        } else {
            $result = array();
        }
        $data_json = json_encode($result);
        return $this->renderText($data_json);
    }
}
