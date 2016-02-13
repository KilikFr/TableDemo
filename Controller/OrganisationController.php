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

}
