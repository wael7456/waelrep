<?php

namespace App\Controller\Admin;

use App\Entity\Postulation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;


class PostulationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Postulation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('candidat'),
            AssociationField::new('offre'),
            TextField::new('cv'),
            TextField::new('lettreMotivation'),
            TextField::new('statut'),
            DateTimeField::new('datePostulation'),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        
        ->disable(Action::NEW);
        
            

    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            
            ->showEntityActionsInlined()
        ;
    }
    public function configureFilters(Filters $filters): Filters
{
    return $filters
        ->add(TextFilter::new('offre'));
}
}
