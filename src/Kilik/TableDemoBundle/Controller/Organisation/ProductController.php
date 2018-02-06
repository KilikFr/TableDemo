<?php

namespace Kilik\TableDemoBundle\Controller\Organisation;

/*
 * This controller demonstrate how to hard-code filtering through route parameters
 * with custom query builder
 */
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\FilterSelect;
use Kilik\TableBundle\Components\Table;
use Kilik\TableDemoBundle\Entity\Organisation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Products actions related to a specified organisation.
 *
 * @Route("/organisation/{organisation}/product")
 */
class ProductController extends Controller
{
    /**
     * Contacts list (with organisation name).
     *
     * @param Organisation $organisation
     *
     * @return Table
     */
    private function getTable(Organisation $organisation)
    {
        $queryBuilder = $this->getDoctrine()->getRepository('KilikTableDemoBundle:Product')->createQueryBuilder('p')
            ->select('p,c')
            ->leftJoin('p.category', 'c')
            // specific hard filters
            ->where('p.organisation = :organisation')
            ->setParameter('organisation', $organisation);

        // product categories (choices)
        $categoriesChoices = [];
        // add empty for placeholder
        $categoriesChoices[''] = '';
        // add a custom value (to select null values)
        $categoriesChoices['without category'] = 'null';
        $categoriesChoices['with category'] = 'not_null';
        foreach (
            $this->getDoctrine()->getRepository('KilikTableDemoBundle:Product\Category')->findBy(
                [],
                ['name' => 'ASC']
            ) as $category
        ) {
            $categoriesChoices[$category->getName()] = $category->getId();
        }

        $table = (new Table())
            ->setId('tabledemo_organisation_product_list')
            ->setPath($this->generateUrl('organisation_product_list_ajax', ['organisation' => $organisation->getId()]))
            ->setQueryBuilder($queryBuilder, 'p')
            ->setTemplate('KilikTableDemoBundle:Organisation/Product:_list.html.twig')
            ->setTemplateParams(['organisation' => $organisation, 'productViewPath' => 'product_view'])
            ->setEntityLoaderRepository('KilikTableDemoBundle:Product');

        $table->addColumn(
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
                        ->setPlaceholder('all')
                        ->setType(Filter::TYPE_EQUAL_STRICT)
                        // define a custom input formatter to handle null and not null values
                        ->setInputFormatter(
                            function (FilterSelect $filter, $defaultOperator, $value) {
                                switch ($value) {
                                    case 'null':
                                        return [Filter::TYPE_NULL, $value];
                                    case 'not_null':
                                        return [Filter::TYPE_NOT_NULL, $value];
                                    default:
                                        return [$defaultOperator, $value];
                                }
                            }
                        )
                )
        );

        $table->addColumn(
            (new Column())
                ->setLabel('City')
                ->setSort(['o.city' => 'asc', 'o.city' => 'asc'])
                ->setHiddenByDefault(true)
                ->setFilter(
                    (new Filter())
                        ->setField('o.city')
                        ->setName('o_city')
                )
        );

        $table->addColumn(
            (new Column())
                ->setLabel('Postal Code')
                ->setSort(['o.postalCode' => 'asc', 'o.postalCode' => 'asc'])
                ->setHiddenByDefault(true)
                ->setFilter(
                    (new Filter())
                        ->setField('o.postalCode')
                        ->setName('o_postalCode')
                )
        );

        $table->addColumn(
            (new Column())
                ->setLabel('Product')
                ->setSort(['p.name' => 'asc', 'o.name' => 'asc'])
                ->setFilter(
                    (new Filter())
                        ->setField('p.name')
                        ->setName('p_name')
                )
        );

        $table->addColumn(
            (new Column())
                ->setLabel('EAN13')
                ->setSort(['p.gtin' => 'asc', 'o.name' => 'asc'])
                ->setFilter(
                    (new Filter())
                        ->setField('p.gtin')
                        ->setName('p_gtin')
                )
        );

        $table->addColumn(
            (new Column())
                ->setLabel('Price')
                ->setSort(['p.price' => 'asc', 'p.name' => 'asc'])
                ->setFilter(
                    (new Filter())
                        ->setField('p.price')
                        ->setName('p_price')
                )
        );

        $table->addColumn(
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
        );

        $table->addColumn(
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
     * @Route("/list", name="organisation_product_list")
     * @Template()
     *
     * @param Organisation $organisation
     *
     * @return array
     */
    public function listAction(Organisation $organisation)
    {
        // get product kilik table
        $table = $this->getTable($organisation);

        return [
            'table' => $this->get('kilik_table')->createFormView($table),
            'organisation' => $organisation,
        ];
    }

    /**
     * @Route("/list/ajax", name="organisation_product_list_ajax")
     *
     * @param Request      $request
     * @param Organisation $organisation
     *
     * @return Response
     */
    public function _listAction(Request $request, Organisation $organisation)
    {
        return $this->get('kilik_table')->handleRequest($this->getTable($organisation), $request);
    }
}
