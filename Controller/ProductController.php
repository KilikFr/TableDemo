<?php

namespace Kilik\TableDemoBundle\Controller;

/**
 * Symfony
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * KilikTableBundle 
 */
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\Table;
/**
 * KilikTableDemoBundle 
 */
use Kilik\TableDemoBundle\Entity\Product;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{

    /**
     * Contacts list (with organisation name)
     */
    public function getProductTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository("KilikTableDemoBundle:Product")->createQueryBuilder("p")
                ->select("p,o")
                ->leftJoin("p.organisation", "o")
        ;

        $table = (new Table())
                ->setId("tabledemo_product_list")
                ->setPath($this->generateUrl("product_list_ajax"))
                ->setQueryBuilder($queryBuilder, "p")
                ->setTemplate("KilikTableDemoBundle:Product:_list.html.twig")
                ->setTemplateParams(["productViewPath"=>"product_view"])
                ->addColumn(
                        (new Column())->setLabel("Organisation")
                        ->setSort(["o.name"=>"asc", "p.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.name")
                                ->setName("o_name")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("Product")
                        ->setSort(["p.name"=>"asc", "o.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("p.name")
                                ->setName("p_name")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("EAN13")
                        ->setSort(["p.gtin"=>"asc", "o.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("p.gtin")
                                ->setName("p_gtin")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("Price")
                        ->setSort(["p.price"=>"asc", "p.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("p.price")
                                ->setName("p_price")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("Stock")
                        ->setSort(["p.stockQuantity"=>"asc", "p.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("p.stockQuantity")
                                ->setName("p_stockQuantity")
                        )
                        ->setDisplayCallback(function($value, $row) {
                            if ($value < 100) {
                                return "<font color='red'><b>".$value."</b></font>";
                            }
                            else {
                                return "<font color='green '>".$value."</font>";
                            }
                        })
                )
                ->addColumn(
                (new Column())->setLabel("Creation Date")
                ->setSort(["p.creationDateTime"=>"asc", "p.name"=>"asc"])
                ->setDisplayFormat(Column::FORMAT_DATE)
                ->setDisplayFormatParams("d/m/Y")
                ->setFilter((new Filter())
                        ->setField("p.creationDateTime")
                        ->setName("p_creationDateTime")
                        ->setDataFormat(Filter::FORMAT_DATE)
                )
        );


        return $table;
    }

    /**
     * Export standard CSV data (results of the list)
     * 
     * @Route("/list/export", name="product_list_export")
     */
    public function listExportAction(Request $request)
    {

        return (new Response($this->get("kilik_table")->exportAsCsv($this->getProductTable(), $request)));
    }

    /**
     * @Route("/list", name="product_list")
     * @Template()
     */
    public function listAction()
    {
        return ["table"=>$this->get("kilik_table")->createFormView($this->getProductTable())];
    }

    /**
     * @Route("/list/ajax", name="product_list_ajax")
     */
    public function _listAction(Request $request)
    {
        return $this->get("kilik_table")->handleRequest($this->getProductTable(), $request);
    }

    /**
     * Production view
     * 
     * @param Product $p
     * @Route("/view/{id}", name="product_view")
     * @Template()
     */
    public function viewAction(Product $p)
    {
        return ["product"=>$p];
    }

}
