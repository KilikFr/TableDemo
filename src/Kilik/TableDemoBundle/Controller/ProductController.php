<?php

namespace Kilik\TableDemoBundle\Controller;

/*
 * Symfony
 */
use Kilik\TableBundle\Components\FilterSelect;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/*
 * KilikTableBundle
 */
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\Table;
/*
 * KilikTableDemoBundle
 */
use Kilik\TableDemoBundle\Entity\Product;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Contacts list (with organisation name).
     */
    public function getProductTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository('KilikTableDemoBundle:Product')->createQueryBuilder('p')
            ->select('p,o,c')
            ->leftJoin('p.organisation', 'o')
            ->leftJoin('p.category', 'c');

        // product categories (choices)
        $categoriesChoices = [];
        // add empty for placeholder
        $categoriesChoices[""] = "";
        // add a custom value (to select null values)
        $categoriesChoices["without category"] = "null";
        $categoriesChoices["with category"] = "not_null";
        foreach ($this->getDoctrine()->getRepository('KilikTableDemoBundle:Product\Category')->findBy(
            [],
            ["name" => "ASC"]
        ) as $category) {
            $categoriesChoices[$category->getName()] = $category->getId();
        }

        $table = (new Table())
            ->setId('tabledemo_product_list')
            ->setPath($this->generateUrl('product_list_ajax'))
            ->setQueryBuilder($queryBuilder, 'p')
            ->setTemplate('KilikTableDemoBundle:Product:_list.html.twig')
            ->setTemplateParams(['productViewPath' => 'product_view'])
            ->addCustomOption('sortColumnClassSorted', 'glyphicon-sort-by-attributes')
            ->addCustomOption('sortColumnClassSortedReverse', 'glyphicon-sort-by-attributes-alt')
            ->addColumn(
                (new Column())
                    ->setLabel('Organisation')
                    ->setSort(['o.name' => 'asc', 'p.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.name')
                            ->setName('o_name')
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('Category')
                    ->setName('c_name')
                    ->setDisplayCallback(
                        function ($value, $row, $rows) {
                            if (is_null($value)) {
                                return '<font color="gray"><i>NO CATEGORY</i></font>';
                            }
                        return $value;
                    }
                    )
                    // to accept html render display values
                    ->setRaw(true)
                    // default sort
                    ->setSort(['c.name' => 'asc', 'p.name' => 'asc'])
                    // set select filter
                    ->setFilter(
                        (new FilterSelect())
                            ->setField('c.id')
                            ->setName('c_id')
                            ->setChoices($categoriesChoices)
                            ->setPlaceholder("all")
                            ->setType(Filter::TYPE_EQUAL_STRICT)
                            // define a custom input formatter to handle null and not null values
                            ->setInputFormatter(
                                function (FilterSelect $filter, $defaultOperator, $value) {
                                    switch ($value) {
                                        case "null":
                                            return [Filter::TYPE_NULL, $value];
                                        case "not_null":
                                            return [Filter::TYPE_NOT_NULL, $value];
                                        default:
                                            return [$defaultOperator, $value];
                                    }
                                }
                            )
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('City')
                    ->setSort(['o.city' => 'asc', 'o.city' => 'asc'])
                    ->setHiddenByDefault(true)
                    ->setFilter(
                        (new Filter())
                            ->setField('o.city')
                            ->setName('o_city')
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('Postal Code')
                    ->setSort(['o.postalCode' => 'asc', 'o.postalCode' => 'asc'])
                    ->setHiddenByDefault(true)
                    ->setFilter(
                        (new Filter())
                            ->setField('o.postalCode')
                            ->setName('o_postalCode')
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('Product')
                    ->setSort(['p.name' => 'asc', 'o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('p.name')
                            ->setName('p_name')
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('EAN13')
                    ->setSort(['p.gtin' => 'asc', 'o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('p.gtin')
                            ->setName('p_gtin')
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('Price')
                    ->setSort(['p.price' => 'asc', 'p.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('p.price')
                            ->setName('p_price')
                    )
            )
            ->addColumn(
                (new Column())
                    ->setLabel('Stock')
                    ->setSort(['p.stockQuantity' => 'asc', 'p.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('p.stockQuantity')
                            ->setName('p_stockQuantity')
                    )
                    ->setRaw(true)
                    ->setDisplayCallback(
                        function ($value, $row) {
                            if ($value < 100) {
                                return "<font color='red'><b>".$value.'</b></font>';
                            } else {
                                return "<font color='green '>".$value.'</font>';
                            }
                        }
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Creation Date')
                    ->setSort(['p.creationDateTime' => 'asc', 'p.name' => 'asc'])
                    ->setDisplayFormat(Column::FORMAT_DATE)
                    ->setDisplayFormatParams('d/m/Y')
                    ->setFilter(
                        (new Filter())
                            ->setField('p.creationDateTime')
                            ->setName('p_creationDateTime')
                            ->setDataFormat(Filter::FORMAT_DATE)
                    )
            );

        return $table;
    }

    /**
     * Export standard CSV data (results of the list).
     *
     * @Route("/list/export", name="product_list_export")
     */
    public function listExportAction(Request $request)
    {
        $response = new Response($this->get('kilik_table')->exportAsCsv($this->getProductTable(), $request));
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="products.csv"');

        return $response;
    }

    /**
     * @Route("/list", name="product_list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        // get product kilik table
        $table=$this->getProductTable();

        // handle optionnal force refresh/default filters
        if(!is_null($request->get('organisation'))) {
            // set default value
            $table->getColumnByName('o_name')->getFilter()->setDefaultValue($request->get('organisation'));
            // and disable filters and pagination loading from client local storage
            $table->setSkipLoadFromLocalStorage(true);
        }

        return ['table' => $this->get('kilik_table')->createFormView($table)];
    }

    /**
     * @Route("/list/ajax", name="product_list_ajax")
     */
    public function _listAction(Request $request)
    {
        return $this->get('kilik_table')->handleRequest($this->getProductTable(), $request);
    }

    /**
     * Production view.
     *
     * @param Product $p
     * @Route("/view/{id}", name="product_view")
     * @Template()
     *
     * @return array
     */
    public function viewAction(Product $p)
    {
        return ['product' => $p];
    }
}
