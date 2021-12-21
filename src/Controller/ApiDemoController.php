<?php

namespace App\Controller;

use Kilik\TableBundle\Components\ApiTable;
use Kilik\TableBundle\Services\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\Table;

/**
 * @Route("/api-demo")
 * @deprecated api demo not maintained
 */
class ApiDemoController extends AbstractController
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
                    ->setFilter(
                        (new Filter())
                            ->setField('first_name')
                            ->setName('first_name')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Last Name')
                    ->setSort(['last_name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('last_name')
                            ->setName('last_name')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Avatar')
                    ->setName('avatar')
                    ->setDisplayCallback(function ($value) {
                        return '<img src="'.$value.'"/>';
                    })
                    ->setRaw(true)

            );

        return $table;
    }

    /**
     * @Route("/list", name="api_user_list")
     */
    public function listAction(TableService $tableService)
    {
        return $this->render(
            'api_demo/list.html.twig',
            [
                'table' => $tableService->createFormView($this->getTable()),
            ]
        );
    }

    /**
     * @Route("/list/ajax", name="api_user_list_ajax")
     */
    public function _listAction(Request $request, TableService $tableService)
    {
        // ! note this is the special api service
        return $tableService->handleRequest($this->getTable(), $request);
    }
}
