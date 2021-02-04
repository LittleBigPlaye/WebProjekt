<?php
/**
 * Products controller
 * This controller contains different views to show products
 * @author Robin Beck
 */


namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
    /**
     * This view is used to show a specific product.
     * If the given pid is not a number and equals "rand" a random product will be loaded
     * 
     */
    public function actionView()
    {
        $this->setParam('currentPosition', 'products');
        //check if the given pid is valid formatted
        if(!isset($_GET['pid']) || !(is_numeric($_GET['pid']) || $_GET['pid'] == 'random'))
        {
           $this->redirect('index.php?c=errors&a=404');
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
            $this->redirect('index.php?c=errors&a=404');
        }
    }
  
    /**
     * This view is used to list, search filter or sort products
     *
     */
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
        $this->appendINQuery($vendorFilters,   $where, 'vendorsID');
        $this->appendINQuery($categoryFilters, $where, 'categoriesID');
        
       
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

        //add visibility filter, if current user is admin
        if($this->isAdmin() && isset($_GET['hidden'])) {
            $hiddenClause = '';
            if($_GET['hidden'] == 'hidden')
            {
                $hiddenClause = 'isHidden=1';
            }
            else if ($_GET['hidden'] == 'visible')
            {
                $hiddenClause = 'isHidden=0';
            }

            if(!empty($hiddenClause))
            {
                if(!empty($where))
                {
                    $where .= ' AND ';
                }
                $where .= $hiddenClause;
            }
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

        if(isset($_POST['ajax']) && $_POST['ajax'] == 1) 
        {
            if($_GET['page'] > $numberOfPages)
            {
                //send 404 to signalize that there is no product left
                http_response_code(404);
            }
            else
            {
                echo $this->getProductsJson($products);
            }
            exit(0);
        }

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

    /**
     * This function appends a given where clause with given filters
     *
     * @param [type] $filterList    the list of filters that should be set
     * @param [type] $where         the where statement that should be appended
     * @param [type] $attributeName the name of the attribute that should be filtered
     * @return void
     */
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
    
    /**
     * This function appends a given where clause by a search string
     *
     * @param [type] $searchString  the string that should be searched within the database
     * @param [type] $where         the where clause that should be appended
     * @param [type] $attributes    the attributes where the string occurance should be searched in
     * @return void
     */
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

    /**
     * This function calculates how many product pages exist
     *
     * @param string $where used to filter the products, e. g. to ignore hidden products
     * @return void
     */
    private function calculateNumberOfProductPages($where = '')
    {
        //calculate the number of pages
        $numberOfProducts = count(\myf\models\Product::find($where));
        $numberOfPages = ceil($numberOfProducts / PRODUCTS_PER_PAGE);
        return $numberOfPages;
    }


    /**
     * This function makes sure that the current page is between the min
     * number of pages and the max number of pages
     *
     * @param integer $currentPage      the currentPage that should be checked
     * @param integer $numberOfPages    the max number of available pages
     * @return integer $currentPage     the corrected current page
     */
    private function determineCurrentPage($currentPage = 1, $numberOfPages)
    {
        $currentPage = ($currentPage > $numberOfPages) ? $numberOfPages : $currentPage;
        if($currentPage > $numberOfPages)
        {
            $currentPage = $numberOfPages;
        }
        else
        {
            $currentPage = max($currentPage, 1);
        }
        return $currentPage;
    }

    /**
     * This function is used to determine the offset for the findRange function
     *
     * @param int $numberOfPages    the total number of available pages
     * @param int $currentPage      the current page
     * @return int  $startIndex     the offset for findRange
     */
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

    /**
     * Undocumented function
     *
     * @param int $numberOfPages    total amount of pages
     * @param int $currentPage      the current page
     * @param int $startIndex       the offset for findRange
     * @param string $where         the where clause that should be appended
     * @param string $orderBy       an order criteria
     * @return \myf\models\Product  the list of found products
     */
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

    /**
     * This function takes products and returns a json containing information for product cards.
     * It is used for dynamically loading more product cards via ajax
     *
     * @param \myf\models\Product $products the products that should be included in the json string
     * @return string                       the json encoded array
     */
    public function getProductsJson(&$products)
    {
        $productInfos = array();
        foreach($products as $product)
        {
            $thumbnailPath = FALLBACK_IMAGE;
            if($product->images != NULL)
            {
                $thumbnailPath = $product->images[0]->thumbnailPath;
            }
            $currentProductInfo = array(
                'id'            => $product->id,
                'name'          => $product->productName,
                'catchPhrase'   => $product->catchPhrase,
                'image'         => $thumbnailPath,
                'price'         => $product->standardPrice,
                'isHidden'      => $product->isHidden
            );
            array_push($productInfos, $currentProductInfo);
        }
        $jsonString = json_encode($productInfos);
        return $jsonString;
    }

    /**
     * This action is used to list all vendors and at least three products for each vendor
     */
    public function actionVendors() 
    {
        $this->setParam('currentPosition', 'products');

        //check if products should be added to cart
        if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
        {
            $this->addToCart($_POST['addToCart']);
        }

        //fetch all vendors from database
        $vendors = \myf\models\Vendor::find('', 'vendorName ASC');

        //fetch three random products for each vendor
        $vendorProducts = [];
        $db = $GLOBALS['database'];
        foreach($vendors as $key => $vendor)
        {
            $vendorProducts[$key] = \myf\models\Product::findRange(0,3,'vendorsID = ' . $db->quote($vendor->id) . ' AND isHidden=0', 'RAND()');
            
        }

        $this->setParam('vendors', $vendors);
        $this->setParam('vendorProducts', $vendorProducts);
    }
}