<?php
/**
 * @author Robin Beck
 */


namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
     
    public function actionNew()
     {
        $errorMessage = '';
        //TODO check if user is logged in and is admin
        //obtain vendors from database
        $this->setParam('vendors', \myf\core\loadVendors());

        //obtain categories from database
        $this->setParam('categories', \myf\core\loadCategories());

        //check, if form has been submitted
        if(isset($_POST['submit']))
        {
            //get inputs from form
            $name        = $_POST['productName'] ?? '';
            $catchPhrase = $_POST['catchPhrase'] ?? '';
            $description = $_POST['productDescription'] ?? '';
            $price       = $_POST['productPrice'] ?? '';
            $vendor      = $_POST['vendor'] ?? '';
            $category    = $_POST['category'] ?? '';
            $isHidden    = isset($_POST['isHidden']) ? true : false;

            //check, if inputs are valid
            if(!empty($name) && !empty($description) && \myf\core\validateNumberInput($price, 2) && !empty($vendor) && !empty($category))
            {
                //check if product with same name already exists
                if(is_array(\myf\models\Product::findOne('productName LIKE "' . addslashes($name) .'"')))
                {
                    $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                }
                else
                {
                    //check if there are files to be uploaded
                    $fileNames = array_filter($_FILES['productImages']['name']);
                    if(!empty($fileNames))
                    {
                        \myf\core\validateImages($name, 'productImages', $errorMessage);

                        if(empty($errorMessage))
                        {
                            //build new product
                            $product = new \myf\models\Product(array());
                            $product->productName        = addslashes($name);
                            $product->catchPhrase        = $catchPhrase;
                            $product->productDescription = $description;
                            $product->vendorID           = $vendor;
                            $product->categoryID         = $category;
                            $product->standardPrice      = $price;
                            $product->isHidden           = $isHidden;

                            //add images
                            \myf\core\addImagesToProduct($product, 'productImages');

                            //insert product into database
                            $product->save();

                            //redirect to product page
                            header('Location: ?c=products&a=view&prod=' . $product->id);
                        }
                    }
                    else
                    {
                        $errorMessage = 'Bitte wählen Sie mindestens ein Bild zum Upload für das Produkt aus!';
                    }
                }
            }
            else
            {
                $errorMessage = 'Bitte alle Felder ausfüllen!';
            }
        }
        $this->setParam('errorMessage', $errorMessage);
     }

     
     public function actionEdit()
     {
        $errorMessage = '';
        //TODO check if user is logged in and is admin
        //check if product exists
        $productID = $_GET['product'] ?? null;
        $productResult = null;
        if($productID != null)
        {
            $productResult = \myf\models\Product::findOne('id=' . $productID);
        }
        if($productResult != null && is_array($productResult))
        {
            //load Product
            $product = new \myf\models\Product($productResult);

            //obtain vendors from database
            $this->setParam('vendors', \myf\core\loadVendors());

            //obtain categories from database
            $this->setParam('categories', \myf\core\loadCategories());
            $this->setParam('product', $product);
            //get inputs from from
            if(isset($_POST['submit']))
            {
                $name        = $_POST['productName'] ?? '';
                $catchPhrase = $_POST['catchPhrase'] ?? '';
                $description = $_POST['productDescription'] ?? '';
                $price       = $_POST['productPrice'] ?? '';
                $vendor      = $_POST['vendor'] ?? '';
                $category    = $_POST['category'] ?? '';
                $isHidden    = isset($_POST['isHidden']) ? true : false;

                //check if inputs are valid
                if(!empty($name) && !empty($description) && \myf\core\validateNumberInput($price, 2) && !empty($vendor) && !empty($category))
                {
                    //check if product with same name already exists
                    if($name != $product->productName && is_array(\myf\models\Product::findOne('productName LIKE "' . $name .'"')))
                    {
                        $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                    }
                    else
                    {
                        //TODO: image handling
                        //go through all images of the current product
                        foreach($product->images as $productImage)
                        {
                            //TODO: check if image should be deleted
                            $deleteImage = isset($_POST['deleteImage' . $productImage->id]) ? true : false;
                            if($deleteImage)
                            {
                                $productImage->delete();
                            }
                            else
                            {
                                //change image title
                                $newTitle = $_POST['imageName' . $productImage->id] ?? $productImage->name;
                                $productImage->image->imageName = $newTitle;
                                $productImage->image->save();
                            }
                        }

                        //check if there are files to be uploaded
                        $fileNames = array_filter($_FILES['productImages']['name']);
                        if(!empty($fileNames))
                        {
                            //check if all images are okay
                            \myf\core\validateImages($name, 'productImages', $errorMessage);
                            if(empty($errorMessage))
                            {
                                \myf\core\addImagesToProduct($product, 'productImages');
                            }
                        }

                        if(empty($errorMessage))
                        {
                            //apply changes to product
                            $product->productName        = $name;
                            $product->catchPhrase        = $catchPhrase;
                            $product->productDescription = $description;
                            $product->vendorID           = $vendor;
                            $product->categoryID         = $category;
                            $product->standardPrice      = $price;
                            $product->isHidden           = $isHidden;

                            //save product to database
                            $product->save();

                            //redirect to product page
                            header('Location: ?c=products&a=view&prod=' . $product->id);
                        }
                    }
                }
                else
                {
                    $errorMessage = 'Bitte alle Felder ausfüllen!';
                }
            }
            $this->setParam('errorMessage', $errorMessage);
        }
        else
        {
            //TODO: direct to 404 page
            die();
        }
     }

     public function actionView()
     {
         if(isset($_GET['prod']))
         {
            // get product id from url
            $productID = $_GET['prod'];
            //TODO replace isAdmin as soon as the login is done
            $isAdmin = true;
            $whereClause = $isAdmin ? '' : ' AND isHidden=0';
            // try to find product with id in database
            $productResult = \myf\models\Product::findOne('id=' . $productID . $whereClause);

            // check if product has been found
            if(is_array($productResult))
            {
                // create new product
                $product = new \myf\models\Product($productResult);

                // save product temporary in controller to have access from view
                $this->setParam('product', $product);
            }
            else
            {
                // TODO - Redirect to 404 page
                echo "Produkt nicht gefunden";
            }
         }
         else
         {
             //TODO - Redirect to 404 page
             die();
         }
     }
  

    public function actionList()
    {
        //set current position for nav bar highlight
        $this->setParam('currentPosition', 'products');
        
        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = true;
        
        //determine if users should see all products or just hidden products
        $where = $isAdmin ? '' : 'isHidden = 0'; 
        //check how many products are available
        $numberOfPages = 0;
        $currentPage = $_GET['page'] ?? 1; ;
        $startIndex = 0;
               
        $products = \myf\core\prepareProductList($numberOfPages, $currentPage, $startIndex, $where);
        $this->setParam('numberOfPages', $numberOfPages);
        $this->setParam('currentPage', $currentPage);
        $this->setParam('startIndex', $startIndex);
        $this->setParam('products', $products);
    }

    public function actionSearch()
    {
        //obtain vendors from database
        $vendors = \myf\core\loadVendors();
        $this->setParam('vendors', $vendors);

        //obtain categories from database
        $categories = \myf\core\loadCategories();
        $this->setParam('categories', $categories);

        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = true;

        //determine if users should see all products or just hidden products
        $where = $isAdmin ? '' : 'isHidden = 0'; 


        $searchString = $_GET['s'] ?? '';
       
        //retrieve vendorFilters
        $vendorFilters = [];
        foreach($vendors as $vendor)
        {
            if(isset($_GET['v' . $vendor->id]))
            {
                array_push($vendorFilters, $vendor->id);
            }
        }

        //retrieve CategoryFilters
        $categoryFilters = [];
        foreach($categories as $category)
        {
            if(isset($_GET['c' . $category->id]))
            {
                array_push($categoryFilters, $category->id);
            }
        }
        $minPrice = $_GET['minPrice'] ?? '';
        $maxPrice = $_GET['maxPrice'] ?? '';

        //build where
        $this->appendSearchQuery($searchString, $where, array('productName', 'catchPhrase', 'productDescription'));
        $this->appendINQuery($vendorFilters, $where, 'vendorID');
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
        $currentPage = $_GET['page'] ?? 1; ;
        $startIndex = 0;        
        
        $products = \myf\core\prepareProductList($numberOfPages, $currentPage, $startIndex, $where, $order);
        $this->setParam('numberOfPages', $numberOfPages);
        $this->setParam('currentPage', $currentPage);
        $this->setParam('startIndex', $startIndex);
        $this->setParam('products', $products);


        //prepare getString fornavigation
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
            if(!empty($where))
            {
                $where .= ' AND ';
            }
            $where .= $attributeName .' IN (';
                foreach($filterList as $key => $id)
                {
                    $where .= $id . ', ';
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
            
            $where .= '(';
            //replace quotes
            $searchString = $this->escapeSQLString($searchString);
            $splitSearchString = explode(' ', $searchString);
            foreach($splitSearchString as $search)
            {
                if(!empty($search))
                {
                    foreach($attributes as $attribute)
                    {
                        $where .= $attribute . ' LIKE "%' . $search . '%" OR ';
                    }
                }
            }
            $where = trim($where, ' OR ');
            $where .= ')';
        }       
    }

    private function escapeSQLString($sqlString)
    {
        $sqlString = str_replace('\\', '\\\\', $sqlString);
        $sqlString = str_replace('\'', '\\\'', $sqlString);
        $sqlString = str_replace('"', '\\"', $sqlString);
        $sqlString = str_replace('%', '\\%', $sqlString);
        $sqlString = str_replace('_', '\\_', $sqlString);
        return $sqlString;
    }

    
 }