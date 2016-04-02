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
 * @Route("/contact")
 */
class ContactController extends Controller
{

    /**
     * Contacts list (with organisation name)
     */
    public function getContactTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository("KilikTableDemoBundle:Contact")->createQueryBuilder("c")
                ->select("c,o,concat(c.firstName,' ',c.lastName) as fullname")
                ->leftJoin("c.organisation", "o")
        ;

        $table = (new Table())
                ->setId("tabledemo_contact_list")
                ->setPath($this->generateUrl("contact_list_ajax"))
                ->setQueryBuilder($queryBuilder, "c")
                ->addColumn(
                        (new Column())->setLabel("Organisation")
                        ->setSort(["o.name"=>"asc", "c.firstName"=>"asc", "c.lastName"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("o.name")
                                ->setName("o_name")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("First Name")
                        ->setSort(["c.firstName"=>"asc", "c.lastName"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("c.firstName")
                                ->setName("c_firstName")
                        )
                )
                ->addColumn(
                        (new Column())->setLabel("Last Name")
                        ->setSort(["c.lastName"=>"asc", "c.firstName"=>"asc"])
                        ->setFilter((new Filter())
                                ->setField("c.lastName")
                                ->setName("c_lastName")
                        )
                )
                ->addColumn(
                (new Column())->setLabel("Full Name")
                ->setSort(["fullname"=>"asc", "fullname"=>"asc"])
                ->setFilter((new Filter())
                        ->setField("fullname")
                        ->setName("fullname")
                        ->setHaving(true)
                )
        );


        return $table;
    }

    /**
     * @Route("/list", name="contact_list")
     * @Template()
     */
    public function listAction()
    {
        return ["table"=>$this->get("kilik_table")->createFormView($this->getContactTable())];
    }

    /**
     * @Route("/list/ajax", name="contact_list_ajax")
     */
    public function _listAction(Request $request)
    {
        return $this->get("kilik_table")->handleRequest($this->getContactTable(), $request);
    }

}
