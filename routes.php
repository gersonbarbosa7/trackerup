<?php

/**
 * Endpoints group started by v1
 */
$app->group('/v1', function() {

    /**
     * v1/category
     */
    $this->group('/category', function() {
        $this->get('', '\App\v1\Controllers\CategoryController:listCategory');
        $this->post('', '\App\v1\Controllers\CategoryController:createCategory');
        
        /**
         * URL Validation
         */
        $this->get('/{id:[0-9]+}', '\App\v1\Controllers\CategoryController:viewCategory');
        $this->put('/{id:[0-9]+}', '\App\v1\Controllers\CategoryController:updateCategory');
        $this->delete('/{id:[0-9]+}', '\App\v1\Controllers\CategoryController:deleteCategory');
    });

    /**
     * v1/item
     */
    $this->group('/item', function() {
        $this->get('', '\App\v1\Controllers\ItemController:listItem');
        $this->post('', '\App\v1\Controllers\ItemController:createItem');
        
        /**
         * URL Validation
         */
        $this->get('/{id:[0-9]+}', '\App\v1\Controllers\ItemController:viewItem');
        $this->get('/list/{id:[0-9]+}', '\App\v1\Controllers\ItemController:listItemByCategory');
        $this->put('/{id:[0-9]+}', '\App\v1\Controllers\ItemController:updateItem');
        $this->delete('/{id:[0-9]+}', '\App\v1\Controllers\ItemController:deleteItem');
    });
});