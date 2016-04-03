<?php

namespace Kilik\TableDemoBundle\Controller;

/**
 * Symfony
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * KilikTableBundle 
 */
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\FilterCheckbox;
use Kilik\TableBundle\Components\FilterSelect;
use Kilik\TableBundle\Components\Table;

/**
 * @Route("/organisation")
 */
class OrganisationController extends Controller
{

    /**
     * Organisations list
     */
    public function getOrganisationTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository("KilikTableDemoBundle:Organisation")->createQueryBuilder("o")
                ->select('o')
        ;

        $table = (new Table())
                ->setRowsPerPage(15) // custom rows per page
                ->setId("tabledemo_organisation_list")
                ->setPath($this->generateUrl("organisation_list_ajax"))
                ->setQueryBuilder($queryBuilder, "o")
                ->addColumn(
                        (new Column())->setLabel("Name")
                        ->setSort(["o.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.name")
                                ->setName("o_name")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("City")
                        ->setSort(["o.city"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.city")
                                ->setName("o_city")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("Post Code")
                        ->setSort(["o.postalCode"=>"asc", "o.name"=>"asc"])
                        ->setSortReverse(["o.postalCode"=>"desc", "o.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.postalCode")
                                ->setName("o_postalCode")
                        )
                )
                ->addColumn(
                (new Column())->setLabel("Country Code")
                ->setSort(["o.countryCode"=>"asc", "o.name"=>"asc"])
                ->setSortReverse(["o.countryCode"=>"desc", "o.name"=>"asc"])
                ->setFilter((new FilterSelect())
                        ->setField("o.countryCode")
                        ->setName("o_countryCode")
                        ->setChoices(["BM"=>"BM", "CA"=>"CA", "FR"=>"FR"])
                        ->setPlaceholder("-- all --")
                )
        );


        return $table;
    }

    /**
     * @Route("/list", name="organisation_list")
     * @Template()
     */
    public function listAction()
    {
        return ["table"=>$this->get("kilik_table")->createFormView($this->getOrganisationTable())];
    }

    /**
     * @Route("/list/ajax", name="organisation_list_ajax")
     */
    public function _listAction(Request $request)
    {
        return $this->get("kilik_table")->handleRequest($this->getOrganisationTable(), $request);
    }

    /**
     * Organisations list
     */
    public function getOrganisationGroupByTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository("KilikTableDemoBundle:Organisation")->createQueryBuilder("o")
                ->select("o,count(c) as nbContacts")
                ->leftJoin("o.contacts", "c")
                ->groupBy("o")
        ;

        $table = (new Table())
                ->setId("tabledemo_organisation_list")
                ->setPath($this->generateUrl("organisation_groupby_list_ajax"))
                ->setQueryBuilder($queryBuilder, "o")
                ->addColumn(
                        (new Column())->setLabel("Name")
                        ->setSort(["o.name"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.name")
                                ->setName("o_name")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("City")
                        ->setSort(["o.city"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.city")
                                ->setName("o_city")
                        )
                )
                ->addColumn(
                (new Column())->setLabel("Contacts")
                ->setName("nbContacts")
                ->setSort(["nbContacts"=>"asc", "o.name"=>"asc"])
                ->setSortReverse(["nbContacts"=>"desc", "o.name"=>"asc"])
                //->setSortReverse(["o.postalCode"=>"desc", "o.name"=>"asc"])
                ->setFilter((new Filter())
                        ->setField("nbContacts")
                        ->setName("nbContacts")
                        ->setHaving(true)
                )
        );


        return $table;
    }

    /**
     * @Route("/list-groupby", name="organisation_groupby_list")
     * @Template()
     */
    public function listGroupByAction()
    {
        return ["table"=>$this->get("kilik_table")->createFormView($this->getOrganisationGroupByTable())];
    }

    /**
     * @Route("/list-groupby/ajax", name="organisation_groupby_list_ajax")
     */
    public function _listGroupByAction(Request $request)
    {
        return $this->get("kilik_table")->handleRequest($this->getOrganisationGroupByTable(), $request);
    }

    /**
     * Organisations with stock info list
     */
    public function getOrganisationCustomTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository("KilikTableDemoBundle:Organisation")->createQueryBuilder("o")
                ->select("o,(select sum(p.price) from KilikTableDemoBundle:Product as p where p.organisation=o) as stockPrice")
        ;

        $table = (new Table())
                        ->setId("tabledemo_organisation_list")
                        ->setPath($this->generateUrl("organisation_custom_list_ajax"))
                        ->setQueryBuilder($queryBuilder, "o")
                        // set the custom template
                        ->setTemplate("KilikTableDemoBundle:Organisation:_listCustom.html.twig")
                        ->addColumn(
                                (new Column())->setLabel("Name")
                                ->setSort(["o.name"=>"asc"])
                                ->setFilter((new Filter())
                                        ->setField("o.name")
                                        ->setName("o_name")
                                )
                        )
                        ->addColumn(
                                (new Column())->setLabel("City")
                                ->setSort(["o.city"=>"asc"])
                                ->setFilter((new Filter())
                                        ->setField("o.city")
                                        ->setName("o_city")
                                )
                        )
                        ->addColumn(
                                (new Column())->setLabel("Stock Price")
                                ->setName("stockPrice")
                                ->setSort(["stockPrice"=>"asc", "o.name"=>"asc"])
                                ->setSortReverse(["stockPrice"=>"desc", "o.name"=>"asc"])
                                ->setFilter((new Filter())
                                        ->setField("stockPrice")
                                        ->setName("stockPrice")
                                        ->setHaving(true)
                                )
                        )
                        // add custom filters
                        ->addFilter((new Filter())
                                ->setType(Filter::TYPE_GREATER_OR_EQUAL)
                                ->setField("stockPrice")
                                ->setName("stockPriceMin")
                                ->setHaving(true)
                        )
                        ->addFilter((new Filter())
                                ->setType(Filter::TYPE_LESS_OR_EQUAL)
                                ->setField("stockPrice")
                                ->setName("stockPriceMax")
                                ->setHaving(true)
                        )->addFilter((new FilterCheckbox())
                        ->setField("o.startup")
                        ->setName("startup")
        );

        return $table;
    }

    /**
     * @Route("/list-custom", name="organisation_custom_list")
     * @Template()
     */
    public function listCustomAction()
    {
        return ["table"=>$this->get("kilik_table")->createFormView($this->getOrganisationCustomTable())];
    }

    /**
     * @Route("/list-custom/ajax", name="organisation_custom_list_ajax")
     */
    public function _listCustomAction(Request $request)
    {
        return $this->get("kilik_table")->handleRequest($this->getOrganisationCustomTable(), $request);
    }

}
