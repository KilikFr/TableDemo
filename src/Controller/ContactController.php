<?php

namespace App\Controller;

use App\Entity\Contact;
use Kilik\TableBundle\Services\TableService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\Table;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry=$managerRegistry;
    }

    /**
     * Contacts list (with organisation name).
     */
    public function getContactTable()
    {
        $queryBuilder = $this->managerRegistry->getRepository(Contact::class)->createQueryBuilder('c')
            ->select("c,o,concat(c.firstName,' ',c.lastName) as fullname")
            ->leftJoin('c.organisation', 'o');

        $table = (new Table())
            ->setId('tabledemo_contact_list')
            ->setPath($this->generateUrl('contact_list_ajax'))
            ->setQueryBuilder($queryBuilder, 'c')
            ->addColumn(
                (new Column())->setLabel('Organisation')
                    ->setSort(['o.name' => 'asc', 'c.firstName' => 'asc', 'c.lastName' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.name')
                            ->setName('o_name')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('First Name')
                    ->setSort(['c.firstName' => 'asc', 'c.lastName' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('c.firstName')
                            ->setName('c_firstName')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Last Name')
                    ->setSort(['c.lastName' => 'asc', 'c.firstName' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('c.lastName')
                            ->setName('c_lastName')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Full Name')
                    ->setSort(['fullname' => 'asc', 'fullname' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('fullname')
                            ->setName('fullname')
                            ->setHaving(true)
                    )
            );

        return $table;
    }

    /**
     * @Route("/list", name="contact_list")
     */
    public function listAction(TableService $tableService)
    {
        return $this->render(
            'contact/list.html.twig',
            [
                'table' => $tableService->createFormView($this->getContactTable()),
            ]
        );
    }

    /**
     * @Route("/list/ajax", name="contact_list_ajax")
     */
    public function _listAction(Request $request, TableService $tableService)
    {
        return $tableService->handleRequest($this->getContactTable(), $request);
    }
}
