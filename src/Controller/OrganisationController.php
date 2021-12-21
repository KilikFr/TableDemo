<?php

namespace App\Controller;

use App\Entity\Organisation;
use Kilik\TableBundle\Services\TableService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Filter;
use Kilik\TableBundle\Components\FilterCheckbox;
use Kilik\TableBundle\Components\FilterSelect;
use Kilik\TableBundle\Components\Table;

/**
 * @Route("/organisation")
 */
class OrganisationController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry=$managerRegistry;
    }
    /**
     * Organisations list.
     */
    public function getOrganisationTable()
    {
        $queryBuilder = $this->managerRegistry->getRepository(Organisation::class)->createQueryBuilder('o')
            ->select('o');

        $table = (new Table())
            ->setRowsPerPage(15)// custom rows per page
            ->setId('tabledemo_organisation_list')
            ->setPath($this->generateUrl('organisation_list_ajax'))
            ->setQueryBuilder($queryBuilder, 'o')
            ->addColumn(
                (new Column())->setLabel('Name')
                    ->setSort(['o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.name')
                            ->setName('o_name')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('City')
                    ->setSort(['o.city' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.city')
                            ->setName('o_city')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Post Code')
                    ->setSort(['o.postalCode' => 'asc', 'o.name' => 'asc'])
                    ->setSortReverse(['o.postalCode' => 'desc', 'o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.postalCode')
                            ->setName('o_postalCode')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Country Code')
                    ->setSort(['o.countryCode' => 'asc', 'o.name' => 'asc'])
                    ->setSortReverse(['o.countryCode' => 'desc', 'o.name' => 'asc'])
                    ->setFilter(
                        (new FilterSelect())
                            ->setField('o.countryCode')
                            ->setName('o_countryCode')
                            ->setChoices(['BM' => 'BM', 'CA' => 'CA', 'FR' => 'FR'])
                            ->setPlaceholder('-- all --')
                            ->disableTranslation() // disable translations of placeholder and values
                    )
            );

        return $table;
    }

    /**
     * @Route("/list", name="organisation_list")
     */
    public function listAction(TableService $tableService)
    {
        return $this->render(
            'organisation/list.html.twig',
            [
                'table' => $tableService->createFormView($this->getOrganisationTable()),
            ]
        );
    }

    /**
     * @Route("/list/ajax", name="organisation_list_ajax")
     */
    public function _listAction(Request $request, TableService $tableService)
    {
        return $tableService->handleRequest($this->getOrganisationTable(), $request);
    }

    /**
     * Organisations list.
     */
    public function getOrganisationGroupByTable()
    {
        $queryBuilder = $this->managerRegistry->getRepository(Organisation::class)->createQueryBuilder('o')
            ->select('o,count(c) as nbContacts')
            ->leftJoin('o.contacts', 'c')
            ->groupBy('o');

        $table = (new Table())
            ->setId('tabledemo_organisation_list')
            ->setPath($this->generateUrl('organisation_groupby_list_ajax'))
            ->setQueryBuilder($queryBuilder, 'o')
            ->addColumn(
                (new Column())->setLabel('Name')
                    ->setSort(['o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.name')
                            ->setName('o_name')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('City')
                    ->setSort(['o.city' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.city')
                            ->setName('o_city')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Contacts')
                    ->setName('nbContacts')
                    ->setSort(['nbContacts' => 'asc', 'o.name' => 'asc'])
                    ->setSortReverse(['nbContacts' => 'desc', 'o.name' => 'asc'])
                    //->setSortReverse(["o.postalCode"=>"desc", "o.name"=>"asc"])
                    ->setFilter(
                        (new Filter())
                            ->setField('nbContacts')
                            ->setName('nbContacts')
                            ->setHaving(true)
                    )
            );

        return $table;
    }

    /**
     * @Route("/list-groupby", name="organisation_groupby_list")
     */
    public function listGroupByAction(TableService $tableService)
    {
        return $this->render(
            'organisation/list_group_by.html.twig',
            [
                'table' => $tableService->createFormView($this->getOrganisationGroupByTable()),
            ]
        );
    }

    /**
     * @Route("/list-groupby/ajax", name="organisation_groupby_list_ajax")
     */
    public function _listGroupByAction(Request $request, TableService $tableService)
    {
        return $tableService->handleRequest($this->getOrganisationGroupByTable(), $request);
    }

    /**
     * Organisations with stock info list.
     */
    public function getOrganisationCustomTable()
    {
        $queryBuilder = $this->managerRegistry->getRepository(Organisation::class)->createQueryBuilder('o')
            ->select('o,(select sum(p.price) from App\Entity\Product as p where p.organisation=o) as stockPrice');

        $table = (new Table())
            ->setId('tabledemo_organisation_list')
            ->setPath($this->generateUrl('organisation_custom_list_ajax'))
            ->setQueryBuilder($queryBuilder, 'o')
            // set the custom template
            ->setTemplate('organisation/_list_custom.html.twig')
            ->addColumn(
                (new Column())->setLabel('Name')
                    ->setSort(['o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.name')
                            ->setName('o_name')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('City')
                    ->setSort(['o.city' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('o.city')
                            ->setName('o_city')
                    )
            )
            ->addColumn(
                (new Column())->setLabel('Stock Price')
                    ->setName('stockPrice')
                    ->setSort(['stockPrice' => 'asc', 'o.name' => 'asc'])
                    ->setSortReverse(['stockPrice' => 'desc', 'o.name' => 'asc'])
                    ->setFilter(
                        (new Filter())
                            ->setField('stockPrice')
                            ->setName('stockPrice')
                            ->setHaving(true)
                    )
            )
            // add custom filters
            ->addFilter(
                (new Filter())
                    ->setType(Filter::TYPE_GREATER_OR_EQUAL)
                    ->setField('stockPrice')
                    ->setName('stockPriceMin')
                    ->setHaving(true)
            )
            ->addFilter(
                (new Filter())
                    ->setType(Filter::TYPE_NOT_LIKE)
                    ->setField('o.city')
                    ->setName('notName')
            )
            ->addFilter(
                (new Filter())
                    ->setType(Filter::TYPE_LESS_OR_EQUAL)
                    ->setField('stockPrice')
                    ->setName('stockPriceMax')
                    ->setHaving(true)
            )->addFilter(
                (new FilterCheckbox())
                    ->setField('o.startup')
                    ->setName('startup')
            );

        return $table;
    }

    /**
     * @Route("/list-custom", name="organisation_custom_list")
     */
    public function listCustomAction(TableService $tableService)
    {
        return $this->render(
            'organisation/list_custom.html.twig',
            [
                'table' => $tableService->createFormView($this->getOrganisationCustomTable()),
            ]
        );
    }

    /**
     * @Route("/list-custom/ajax", name="organisation_custom_list_ajax")
     */
    public function _listCustomAction(Request $request, TableService $tableService)
    {
        return $tableService->handleRequest($this->getOrganisationCustomTable(), $request);
    }
}
