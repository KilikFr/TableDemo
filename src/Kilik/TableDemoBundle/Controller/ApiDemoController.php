<?php

namespace Kilik\TableDemoBundle\Controller;

/*
 * Symfony
 */
use Kilik\TableBundle\Components\ApiTable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/*
 * KilikTableBundle
 */
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\Table;

/**
 * @Route("/api-demo")
 */
class ApiDemoController extends Controller
{
    /**
     * Users lists
     */
    public function getTable()
    {
        $table = (new ApiTable())
                ->setId('tabledemo_user_list')
                ->setPath($this->generateUrl('api_user_list_ajax'))
                // inject your api bridge service
                ->setApi($this->get('kilik.table_demo.services.api.user_service'))
                ->setTemplate('KilikTableDemoBundle:ApiDemo:_list.html.twig')
                ->addColumn(
                        (new Column())->setLabel('first name')
                        ->setSort(['first_name' => 'asc'])
                        ->setFilter((new Filter())
                                ->setField('first_name')
                                ->setName('first_name')
                        )
                )
                ->addColumn(
                        (new Column())->setLabel('Last Name')
                        ->setSort(['last_name' => 'asc'])
                        ->setFilter((new Filter())
                                ->setField('last_name')
                                ->setName('last_name')
                        )
                )
                ->addColumn(
                (new Column())->setLabel('Avatar')
                    ->setName('avatar')
                    ->setDisplayCallback(function($value) {
                        return '<img src="'.$value.'"/>';
                    })
                    ->setRaw(true)

        );

        return $table;
    }

    /**
     * @Route("/list", name="api_user_list")
     * @Template()
     */
    public function listAction()
    {
        return ['table' => $this->get('kilik_table')->createFormView($this->getTable())];
    }

    /**
     * @Route("/list/ajax", name="api_user_list_ajax")
     */
    public function _listAction(Request $request)
    {
        // ! note this is the special api service
        return $this->get('kilik_table_api')->handleRequest($this->getTable(), $request);
    }
}
