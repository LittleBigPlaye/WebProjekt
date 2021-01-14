<?php
/**
 * @author Robin Beck
 */


namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
    public function actionView()
    {
        $this->setParam('currentPosition', 'products');
        //check if the given pid is valid formatted
        if(!isset($_GET['pid']) || !(is_numeric($_GET['pid']) || $_GET['pid'] == 'random'))
        {
           header('Location: index.php?c=errors&a=404');
        }

        //check if there are any success messages in the session
        if(isset($_SESSION['productSuccess']))
        {
            $successMessage = $_SESSION['productSuccess'];
            unset($_SESSION['productSuccess']);
            $this->setParam('successMessage', $successMessage);
        }

        // get product id from url
        $productID = $_GET['pid'];
        
        //TODO replace isAdmin as soon as the login is done
        $isAdmin = $this->isAdmin();
        $whereClause = $isAdmin ? '' : ' AND isHidden=0';

        $product = null;

        // try to find product with id in database
        if($_GET['pid'] == 'random')
        {
            $product = \myf\models\Product::findOne('', 'RAND()');
        }
        else
        {
            $product = \myf\models\Product::findOne('id=' . $productID . $whereClause);
        }

        // check if product has been found
        if($product !== null)
        {
            //check if product should be added to the cart
            if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
            {
                $this->addToCart($_POST['addToCart']);
            }
            
            // save product temporary in controller to have access from view
            $this->setParam('product', $product);
        }
        else
        {
            header('Location: index.php?c=errors&a=404');
        }
    }
  
    public function actionSearch()
    {
        $this->setParam('currentPosition', 'products');
        //check if products should be added to cart
        if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
        {
            $this->addToCart($_POST['addToCart']);
        }
        
        //obtain vendors from database
        $vendors = \myf\models\Vendor::find();
        $this->setParam('vendors', $vendors);

        //obtain categories from database
        $categories = \myf\models\Category::find();
        $this->setParam('categories', $categories);

        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = $this->isAdmin();

        //determine if users should see all products or just hidden products
        $where = $isAdmin ? '' : 'isHidden = 0'; 

        $searchString = $_GET['s'] ?? '';
       
        //retrieve vendorFilters
        $vendorFilters = [];
        foreach($vendors as $vendor)
        {
            if(isset($_GET['ven' . $vendor->id]))
            {
                array_push($vendorFilters, $vendor->id);
            }
        }

        //retrieve CategoryFilters
        $categoryFilters = [];
        foreach($categories as $category)
        {
            if(isset($_GET['cat' . $category->id]))
            {
                array_push($categoryFilters, $category->id);
            }
        }
        $minPrice = $_GET['minPrice'] ?? '';
        $maxPrice = $_GET['maxPrice'] ?? '';

        //build where
        $this->appendSearchQuery($searchString, $where, array('productName', 'catchPhrase', 'productDescription'));
        $this->appendINQuery($vendorFilters,   $where, 'vendorID');
        $this->appendINQuery($categoryFilters, $where, 'categoryID');
        
       
        if(!empty($where) && !empty($minPrice))
        {
            $where .= ' AND ';
        }
        if(!empty($minPrice))
        {
            $where .= 'standardPrice > ' . $minPrice;
        }

        if(!empty($where) && !empty($maxPrice))
        {
            $where .= ' AND ';
        }
        if(!empty($maxPrice))
        {
            $where .= 'standardPrice < ' . $maxPrice;
        }

        //build order part of the sql statement
        $order = '';
        $sort = $_GET['sort'] ?? '';
        switch($sort)
        {
            case 'nameASC':
                $order = 'productName ASC';
                break;
            case 'nameDESC':
                $order = 'productName DESC';
                break;
            case 'priceASC':
                $order = 'standardPrice ASC';
                break;
            case 'priceDESC':
                $order = 'standardPrice DESC';
                break;
            case 'dateASC':
                $order = 'createdAt ASC';
                break;
            case 'dateDESC':
                $order = 'createdAt DESC';
                break;
        }
        
        //check how many products are available
        $numberOfPages = 0;
        $currentPage = $_GET['page'] ?? 1;
        $startIndex = 0;        
        
        $products = $this->prepareProductList($numberOfPages, $currentPage, $startIndex, $where, $order);
        $this->setParam('numberOfPages', $numberOfPages);
        $this->setParam('currentPage', $currentPage);
        $this->setParam('startIndex', $startIndex);
        $this->setParam('products', $products);

        //prepare getString for navigation
        $getString = 'c=products&a=search';
        foreach($_GET AS $name => $value)
        {
            if($name != 'c' && $name != 'a' && $name != 'page')
            {
                $getString .= '&' . $name . '=' . urlencode($value);
            }
        }
        $this->setParam('getString', $getString);

    }

    private function appendINQuery($filterList, &$where, $attributeName)
    {
        if(!empty($filterList))
        {
            $db = $GLOBALS['database'];
            if(!empty($where))
            {
                $where .= ' AND ';
            }
            $where .= $attributeName .' IN (';
                foreach($filterList as $key => $id)
                {
                    $where .= $db->quote($id) . ', ';
                }
            $where = trim($where, ' ,');
            $where .= ')';
        }
    }
    
    private function appendSearchQuery($searchString, &$where, $attributes)
    {
        if(!empty($where) && !empty($searchString))
        {
            $where .= ' AND ';
        }
        if(!empty($searchString))
        {
            $db = $GLOBALS['database'];
            $where .= '(';

            //clean search String from non alphanumerical letters to increase the number of matches
            $searchString = preg_replace( '/[^a-z0-9äöüß ]/i', '', $searchString);

            $splitSearchString = explode(' ', $searchString);
            //prevent searching for the same word multiple times
            $splitSearchString = array_unique($splitSearchString);

            foreach($splitSearchString as $key => $search)
            {
                //limit number keywords to keep the sql query shorter
                if($key == SEARCH_LIMIT)
                {
                    break;
                }
                if(!empty($search))
                {
                    foreach($attributes as $attribute)
                    {
                        $where .= $attribute . ' LIKE ' . $db->quote('%' . $search . '%') . ' OR ';
                    }
                }
            }
            $where = trim($where, ' OR ');
            $where .= ')';
        }       
    }

    private function calculateNumberOfProductPages($where = '')
    {
        //calculate the number of pages
        $numberOfProducts = count(\myf\models\Product::find($where));
        $numberOfPages = ceil($numberOfProducts / PRODUCTS_PER_PAGE);
        return $numberOfPages;
    }


    private function determineCurrentPage($currentPage = 1, $numberOfPages)
    {
        $currentPage = ($currentPage > $numberOfPages) ? $numberOfPages : $currentPage;
        if($numberOfPages > 0 && $currentPage > $numberOfPages)
        {
            $currentPage = $numberOfPages;
        }
        else if($currentPage < 1)
        {
            $currentPage = 1;
        }
        return $currentPage;
    }

    private function calculateStartIndex($numberOfPages, $currentPage)
    {
        if($numberOfPages - $currentPage < PRODUCT_LIST_RANGE)
        {
            $deltaPages = PRODUCT_LIST_RANGE - ($numberOfPages - $currentPage);
            $startIndex = max($currentPage-$deltaPages, 0);
        }
        else
        {
            $startIndex = $currentPage;
        }
        return $startIndex;
    }

    private function prepareProductList(&$numberOfPages, &$currentPage, &$startIndex, $where = '', $orderBy = '')
    {
        $numberOfPages = $this->calculateNumberOfProductPages($where);

        $currentPage = $this->determineCurrentPage($currentPage, $numberOfPages);

        // prepare bottom navigation to always display the same number of sites (except there are less pages than defined in PRODUCT_LIST_RANGE)
        $startIndex = $this->calculateStartIndex($numberOfPages, $currentPage);

        //get products from database
        $products = \myf\models\Product::findRange(($currentPage-1) * PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE, $where, $orderBy);
        return $products;
    }

    public function actionVendors() 
    {
        $this->setParam('currentPosition', 'products');

        //fetch all vendors from database
        $vendors = \myf\models\Vendor::find('', 'vendorName ASC');

        //fetch three random products for each vendor
        $vendorProducts = [];
        foreach($vendors as $key => $vendor)
        {
            $vendorProducts[$key] = \myf\models\Product::findRange(0,3,'vendorID = ' . $vendor->id, 'RAND()');
            
        }

        $this->setParam('vendors', $vendors);
        $this->setParam('vendorProducts', $vendorProducts);
    }
}