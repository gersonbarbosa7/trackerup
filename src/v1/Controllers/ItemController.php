<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Item;

/**
 * Item v1 Controller
 */
class ItemController {

    /**
     * Container Class
     * @var [object]
     */
    private $container;

    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container) {
        $this->container = $container;
    }
    
    /**
     * Categories list
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function listItem($request, $response, $args) {
        $entityManager = $this->container->get('em');
        $ItemsRepository = $entityManager->getRepository('App\Models\Entity\Item');
        $Items = $ItemsRepository->findAll();
        $return = $response->withJson($Items, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;        
    }

    /**
     * Get Item By CategoryID
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function listItemByCategory($request, $response, $args) {
        
        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $ItemsRepository = $entityManager->getRepository('App\Models\Entity\Item');
        $Item = $ItemsRepository->findBy(
            array('categoryId' => $id)
        ); 

        $return = $response->withJson($Item, 200)
            ->withHeader('Content-type', 'application/json');
        return $return; 
              
    }
    
    /**
     * Create an Item
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function createItem($request, $response, $args) {
        $params = (object) $request->getParams();
        /**
         * Get Container
         */
        $entityManager = $this->container->get('em');
        /**
         * Entity instance for parameter
         */
        $Item = (new Item())->setName($params->name)
            ->setCategoryId($params->categoryId);
        
        /**
         * Database persist
         */
        $entityManager->persist($Item);
        $entityManager->flush();
        $return = $response->withJson($Item, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Show Item
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function viewItem($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $ItemsRepository = $entityManager->getRepository('App\Models\Entity\Item');
        $Item = $ItemsRepository->find($id); 

        /**
         * Check if Item exists
         */
        if (!$Item) {
            $logger = $this->container->get('logger');
            $logger->warning("Item {$id} Not Found");
            throw new \Exception("Item not Found", 404);
        }    

        $return = $response->withJson($Item, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;   
    }

    /**
     * Update an Item
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function updateItem($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Find Item
         */ 
        $entityManager = $this->container->get('em');
        $ItemsRepository = $entityManager->getRepository('App\Models\Entity\Item');
        $Item = $ItemsRepository->find($id);   

        /**
         * Update parameters
         */
        $Item->setName($request->getParam('name'))
            ->setDescription($request->getParam('description'));

        /**
         * Database persist
         */
        $entityManager->persist($Item);
        $entityManager->flush();        
        
        $return = $response->withJson($Item, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Delete an Item
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function deleteItem($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Find Item
         */ 
        $entityManager = $this->container->get('em');
        $ItemsRepository = $entityManager->getRepository('App\Models\Entity\Item');
        $Item = $ItemsRepository->find($id);   

        /**
         * Remove entity
         */
        $entityManager->remove($Item);
        $entityManager->flush(); 
        $return = $response->withJson(['msg' => "Deletando a categoria {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;    
    }
    
}