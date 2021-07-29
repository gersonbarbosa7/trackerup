<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Category;

/**
 * Category v1 Controller
 */
class CategoryController {

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
    public function listCategory($request, $response, $args) {
        $entityManager = $this->container->get('em');
        $CategorysRepository = $entityManager->getRepository('App\Models\Entity\Category');
        $Categorys = $CategorysRepository->findAll();
        $return = $response->withJson($Categorys, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;        
    }
    
    /**
     * Create an category
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function createCategory($request, $response, $args) {
        $params = (object) $request->getParams();
        /**
         * Get Container
         */
        $entityManager = $this->container->get('em');
        /**
         * Entity instance for parameter
         */
        $Category = (new Category())->setName($params->name)
            ->setDescription($params->description);
        
        /**
         * Database persist
         */
        $entityManager->persist($Category);
        $entityManager->flush();
        $return = $response->withJson($Category, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Show category
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function viewCategory($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $CategorysRepository = $entityManager->getRepository('App\Models\Entity\Category');
        $Category = $CategorysRepository->find($id); 

        /**
         * Check if category exists
         */
        if (!$Category) {
            $logger = $this->container->get('logger');
            $logger->warning("Category {$id} Not Found");
            throw new \Exception("Category not Found", 404);
        }    

        $return = $response->withJson($Category, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;   
    }

    /**
     * Update an category
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function updateCategory($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Find category
         */ 
        $entityManager = $this->container->get('em');
        $CategorysRepository = $entityManager->getRepository('App\Models\Entity\Category');
        $Category = $CategorysRepository->find($id);   

        /**
         * Check if exists
         */
        if (!$Category) {
            $logger = $this->container->get('logger');
            $logger->warning("Category {$id} Not Found");
            throw new \Exception("Category not Found", 404);
        }  

        /**
         * Update parameters
         */
        $Category->setName($request->getParam('name'))
            ->setDescription($request->getParam('description'));

        /**
         * Database persist
         */
        $entityManager->persist($Category);
        $entityManager->flush();        
        
        $return = $response->withJson($Category, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;       
    }

    /**
     * Delete an category
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function deleteCategory($request, $response, $args) {

        $id = (int) $args['id'];

        /**
         * Find category
         */ 
        $entityManager = $this->container->get('em');
        $CategorysRepository = $entityManager->getRepository('App\Models\Entity\Category');
        $Category = $CategorysRepository->find($id);   

        /**
         * Check if exists
         */
        if (!$Category) {
            $logger = $this->container->get('logger');
            $logger->warning("Category {$id} Not Found");
            throw new \Exception("Category not Found", 404);
        }  

        /**
         * Remove entity
         */
        $entityManager->remove($Category);
        $entityManager->flush(); 
        $return = $response->withJson(['msg' => "Deletando a categoria {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
        return $return;    
    }
    
}